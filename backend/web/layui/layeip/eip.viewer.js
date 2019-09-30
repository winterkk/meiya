layui.define(['laytpl', 'layer'], function (exports) {
    var $ = layui.jquery
        , laytpl = layui.laytpl
        , layer = layui.layer
        , setter = layui.setter
        , device = (layui.device(), layui.hint())
        , workspace = setter.workspace;
    var view = function (e) { return new main(e); },
        main = function (e) { this.id = e, this.container = $("#" + (e || workspace)); };

    //格式化路由
    view.reviseRouter = function (href) {
        return /^\//.test(href) || (href = "/" + href), href.replace(/^(\/+)/, "/").replace(new RegExp("/" + setter.pages.console + "$"), "/");
    };
    //显示加载动画
    view.showloading = function (e) {
        e.append(this.eleLoading = $('<i class="layui-anim layui-anim-rotate layui-anim-loop layui-icon layui-icon-loading layeip-loading"></i>'));
    };
    //隐藏加载动画
    view.hideloading = function (e) {
        this.eleLoading && this.eleLoading.remove();
    };
    //弹出对话框
    view.popup = function (option) {
        var success = option.success, skin = option.skin;
        return delete option.success, delete option.skin, layer.open($.extend({
            id: "eip-system-view-popup", type: 1, title: "提示", content: "",
            skin: "layui-layer-eip" + (skin ? " " + skin : ""),
            shadeClose: true, closeBtn: false, resize: false,
            success: function (e, r) {
                e.append($('<i class="layui-icon" close>&#x1006;</i>').on("click", function () { layer.close(r); }));
                typeof success === "function" && success.apply(this, arguments);
            }
        }, option));
    };
    //询问对话框
    view.confirm = function (option) {
        var yes = option.yes,
            cancel = option.cancel,
            content = option.content,
            skin = option.skin;
        return delete option.yes, delete option.cancel, delete option.content, delete option.skin,
            layer.confirm(content, $.extend({
                id: "eip-system-view-confirm",
                title: "提示",
                skin: "layui-layer-eip" + (skin ? " " + skin : ""),
                fixed: true
            }, option), yes, cancel);
    };
    //弹出异常对话框
    view.error = function (content, option) {
        return this.popup($.extend({ content: content, maxWidth: 300, offset: "t", anim: 6, id: "eip_system_error" }, option));
    };
    //输出调试信息
    view.debug = function (url) {
        return setter.debug && url ? "<br><cite>URL：</cite>" + url : "";
    };
    //注销登录
    view.exit = function () { location.href = setter.pages.login; };
    //发送请求
    view.request = function (options) {
        var success = options.success
            , request = (options.error, setter.request)
            , response = setter.response;
        //if (options.data = options.data || {}, options.headers = options.headers || {}, request.tokenName) {
        //    var data = typeof options.data === "string" ? JSON.parse(options.data) : options.data;
        //    options.data[request.tokenName] = request.tokenName in data ? options.data[request.tokenName] : layui.data(setter.tableName)[request.tokenName] || "";
        //    options.headers[request.tokenName] = request.tokenName in options.headers ? options.headers[request.tokenName] : layui.data(setter.tableName)[request.tokenName] || "";
        //}
        options.data = options.data || {}, options.headers = options.headers || {};
        return delete options.success, delete options.error, $.ajax($.extend({
            type: options.type || "get",
            dataType: "json",
            success: function (result) {
                var codes = response.statusCode;
                if (result[response.statusName] === codes.ok)
                    typeof options.done === "function" && options.done(result);
                else if (result[response.statusName] === codes.unlogged)
                    view.exit();
                else {
                    var info = ["<cite>Error：</cite> " + (result[response.msgName] || "返回状态码异常"), view.debug(options.url)].join("");
                    view.error(info);
                }
                typeof success === "function" && success(result);
            },
            error: function (e, result) {
                view.error(["请求异常，请重试<br><cite>错误信息：</cite>" + result, view.debug(options.url)].join(""));
                typeof success === "function" && success(options.res);
            }
        }, options));
    };

    //重绘视图
    main.prototype.render = function (url, params, method) {
        var $this = this;
        layui.router();
        $("#" + workspace).children(".layeip-loading").remove();
        view.showloading($this.container);
        $.ajax({
            url: url,
            type: method || "get",
            dataType: "html",
            data: { v: setter.version },
            success: function (result) {
                result = "<div>" + result + "</div>";
                var otitle = $(result).find("title"),
                    title = otitle.text() || (result.match(/\<title\>([\s\S]*)\<\/title>/) || [])[1],
                    page = { title: title, body: result };
                otitle.remove();
                $this.params = params || {};
                $this.then && ($this.then(page), delete $this.then);
                $this.convert(result);
                view.hideloading();
                $this.done && ($this.done(page), delete $this.done);
            },
            error: function (e) {
                view.hideloading();
                view.error(["请求视图文件异常，状态：" + e.status, view.debug(url)].join(""));
                //window.history.go(-1);
                setter.debug || console.clear();
            }
        });
        return $this;
    };
    //转换模板
    main.prototype.convert = function (source, action, callback) {
        var $this = this,
            isObject = typeof source === "object",
            target = isObject ? source : $(source),
            subs = isObject ? source : target.find("*[template]"),
            router = layui.router(),
            actuator = function (input) {
                var content = laytpl(input.dataElem.html()),
                    data = $.extend({ params: router.params }, input.res);
                input.dataElem.after(content.render(data));
                typeof callback === "function" && callback();
                try {
                    input.done && new Function("d", input.done)(data);
                } catch (i) {
                    console.error(input.dataElem[0], "存在错误的回调脚本", i);
                }
            };
        target.find("title").remove();
        $this.container[action ? "after" : "html"](target.children());
        router.params = $this.params || {};
        $(subs).each(function () {
            var tpl = $(this),
                url = laytpl(tpl.attr("lay-url") || "").render(router),
                funDone = tpl.attr("lay-done") || tpl.attr("lay-then"),
                data = laytpl(tpl.attr("lay-data") || "").render(router),
                headers = laytpl(tpl.attr("lay-headers") || "").render(router);
            try {
                data = new Function("return " + data + ";")();
            } catch (d) {
                device.error("lay-data: " + d.message), data = {};
            }
            try {
                headers = new Function("return " + headers + ";")();
            } catch (d) {
                device.error("lay-headers: " + d.message), headers = headers || {};
            }
            url ? view.request({
                type: tpl.attr("lay-type") || "post",
                url: url + (url.indexOf("?") === -1 ? "?" : "&") + "_r=" + Math.random(),
                data: data,
                dataType: "json",
                //headers: headers,
                success: function (a) {
                    actuator({ dataElem: tpl, res: a, done: funDone });
                }
            }) : actuator({ dataElem: tpl, done: funDone });
        });
    };
    main.prototype.send = function (e, t) {
        var html = laytpl(e || this.container.html()).render(t || {});
        return this.container.html(html), this;
    };
    main.prototype.refresh = function (func) {
        var $this = this,
            elem = $this.container.next(),
            templateid = elem.attr("lay-templateid");
        return $this.id != templateid ? $this : (
            $this.parse($this.container, "refresh", function () {
                $this.container.siblings('[lay-templateid="' + $this.id + '"]:last').remove();
                typeof func === "function" && func();
            }),
            $this
        );
    };
    main.prototype.then = function (func) {
        return this.then = func, this;
    };
    main.prototype.done = function (func) {
        return this.done = func, this;
    };

    exports("viewer", view);
});