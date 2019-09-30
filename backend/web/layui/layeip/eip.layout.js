layui.define(['viewer','form'], function (exports) {
    var $ = layui.jquery
        , element = layui.element
        , setter = layui.setter
        , view = layui.viewer
        , form = layui.form
        , win = $(window)
        , body = $("body")
        , container = $("#" + setter.container)
        , menuId = "eip-system-side-menu"
        ;

    //Layout 定义
    var Layout = {
        version: "1.0.0",
        reviseRouter: function (href) {
            return view.reviseRouter(href);
        },
        //进行HTML编码
        escape: function (input) {
            return String(input || "").replace(/&(?!#?[a-zA-Z0-9]+;)/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/'/g, "&#39;").replace(/"/g, "&quot;");
        },
        //布局事件绑定
        on: function (e, a) {
            return layui.onevent.call(this, setter.modName, e, a);
        },
        tabsPage: {},
        tabsHeader: function (index) {
            return $("#eip_app_tabsheader").children("li").eq(index || 0);
        },
        tabsBody: function (index) {
            return $("#eip_app_body").find(".layeip-tabsbody-item").eq(index || 0);
        },
        tabsBodyChange: function (index) {
            Layout.tabsHeader(index).attr("lay-attr", layui.router().href);
            Layout.tabsBody(index).addClass('layui-show').siblings().removeClass('layui-show');
            Events.rollTab("auto", index);
        },
        //定义屏幕分辨率类型
        screen: function () {
            var width = win.width();
            return width > 1200 ? 3 : width > 992 ? 2 : width > 768 ? 1 : 0;
        },
        //重置表格布局。delay=延迟事件（毫秒）
        resizeTable: function (delay) {
            var $this = this,
                action = function () {
                    $this.tabsBody(Layout.tabsPage.index).find(".layui-table-view").each(function () {
                        var tabid = $(this).attr("lay-id");
                        layui.table.resize && layui.table.resize(tabid);
                    });
                };
            layui.table && (delay ? setTimeout(action, delay) : action());
        },
        // 显示隐藏侧边导航
        sideFlexible: function (flag) {
            var _container = container, btn = $("#eip_app_flexible"), screen = Layout.screen();
            if ("spread" === flag) {
                btn.removeClass('layui-icon-spread-left').addClass('layui-icon-shrink-right'),
                    screen < 2 ? _container.addClass('layeip-side-spread-sm') : _container.removeClass('layeip-side-spread-sm'),
                    _container.removeClass('layeip-side-shrink');
            } else {
                btn.removeClass('layui-icon-shrink-right').addClass('layui-icon-spread-left'),
                    screen < 2 ? _container.removeClass('layeip-side-shrink') : _container.addClass('layeip-side-shrink'),
                    _container.removeClass('layeip-side-spread-sm');
            }
            layui.event.call(this, setter.modName, "side({*})", { status: flag });
        },
        //使左侧菜单项获取焦点
        sideFocus: function () {
            var menu = $("#" + menuId),
                href = this.reviseRouter(layui.router().path.join("/"));
            menu.find(".layui-this").removeClass("layui-this");
            menu.find("li.layui-nav-itemed").removeClass("layui-nav-itemed");
            menu.find("a[lay-href='" + href + "']:first").parent().addClass("layui-this").closest("li").addClass("layui-nav-itemed");
        },
        //全屏
        fullScreen: function () {
            var doc = document.documentElement,
                method = doc.requestFullScreen || doc.webkitRequestFullScreen || doc.mozRequestFullScreen || doc.msRequestFullscreen;
            typeof method !== "undefined" && method && method.call(doc);
        },
        //退出全屏
        exitScreen: function () {
            document.documentElement;
            document.exitFullscreen ? document.exitFullscreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitCancelFullScreen ? document.webkitCancelFullScreen() : document.msExitFullscreen && document.msExitFullscreen();
        },
        closeThisTabs: function () {
            Layout.tabsPage.index && $("#eip_app_tabsheader>li").eq(Layout.tabsPage.index).find(".layui-tab-close").trigger("click");
        },
        resize: function (func) {
            var router = layui.router(),
                path = router.path.join("-");
            Layout.resizeFn[path] && (win.off("resize", Layout.resizeFn[path]),
                delete Layout.resizeFn[path]),
                "off" !== func && (func(),
                    Layout.resizeFn[t] = e,
                    win.on("resize", Layout.resizeFn[path])
                );
        },
        resizeFn: {},
        runResize: function () {
            var e = layui.router()
                , a = e.path.join("-");
            C.resizeFn[a] && C.resizeFn[a]();
        },
        delResize: function () {
            this.resize("off");
        },
        //通用导入视图
        import: function (title, server, callback) {
            var importFormId = "import_form",
                poindex = view.popup({
                    id: "eip-popup-artist-form-modify", title: title, area: ['500px', '240px'], shadeClose: false,
                    btn: ['导入', '取消'], btnAlign: 'c',
                    btn1: function () {
                        $('#' + importFormId + '_submit').click();
                    },
                    btn2: function () {
                        layer.close(poindex);
                    },
                    success: function () {
                        view(this.id)
                            .render("pages/examples/import_form.html", { _FormId: importFormId })
                            .done(function () {
                                form.on('submit(' + importFormId + '_submit)', function (data) {
                                    $.post(server, data.field, function (result) {
                                        result = typeof result === "string" ? JSON.parse(result) : result;
                                        if (result[setter.response.statusName] === setter.response.statusCode.ok) {
                                            layer.close(poindex);
                                            layer.msg("导入成功");
                                            typeof callback === "function" && callback.call(this, data);
                                        } else {
                                            view.error(result[setter.response.msgName]);
                                        }
                                    });
                                    return false;
                                });
                            });
                    }
                });
        },
        //通用导出操作
        export: function (server, parameters, callback) {
            view.showloading($("body"));
            $.ajax({
                url: server,
                type: 'post',
                async: true,
                data: parameters,
                success: function () {
                    view.hideloading();
                    layer.msg("导出成功");
                    typeof callback === "function" && callback.call(this);
                },
                error: function (e) {
                    view.hideloading();
                    view.error(["请求异常，状态：" + e.status, view.debug(url)].join(""));
                    setter.debug || console.clear();
                }
            });
        }
    };
    //标签管理
    var Tabs = function (ele) {
        var attr = ele.attr("lay-attr")
            , index = ele.index();
        location.hash = Layout.reviseRouter(attr || setter.pages.console);
        Layout.tabsBodyChange(index);
    };
    //事件定义
    var Events = Layout.events = {
        flexible: function (el) {
            var obj = el.find("#eip_app_flexible"), isSpread = obj.hasClass("layui-icon-spread-left");
            Layout.sideFlexible(isSpread ? "spread" : null), Layout.resizeTable(350);
        },
        refresh: function () {
            layui.eip.render();
        },
        message: function () {
            console.log("message");
        },
        theme: function () {
            console.log("theme");
        },
        note: function () {
            console.log("note");
        },
        fullscreen: function (ele) {
            var classfull = "layui-icon-screen-full",
                classexit = "layui-icon-screen-restore",
                el = ele.children("i");
            el.hasClass(classfull)
                ? (Layout.fullScreen(), el.addClass(classexit).removeClass(classfull))
                : (Layout.exitScreen(), el.addClass(classfull).removeClass(classexit));
        },
        rollTab: function (position, index) {
            var header = $("#eip_app_tabsheader"),
                tabs = header.children("li"),
                width = (header.prop("scrollWidth"), header.outerWidth()),
                left = parseFloat(header.css("left"));
            if (position === "left") {
                if (!left && left <= 0) return;
                var float = -left - width;
                tabs.each(function () {
                    var _left = $(this).position().left;
                    if (_left >= float)
                        return header.css("left", -_left), false;
                });
            } else if (position === "auto") {
                var tableft, tab = tabs.eq(index);
                if (tab[0]) {
                    if (tableft = tab.position().left, tableft < -left)
                        return header.css("left", -tableft);
                    if (tableft + tab.outerWidth() >= width - left) {
                        var f = tableft + tab.outerWidth() - (width - left);
                        tabs.each(function () {
                            var _left = $(this).position().left;
                            if (_left + left > 0 && _left - left > f)
                                return header.css("left", -_left), false;
                        });
                    }
                }
            } else {
                tabs.each(function () {
                    var _left = $(this).position().left;
                    if (_left + $(this).outerWidth() >= width - left)
                        return header.css("left", -_left), false;
                });
            }
        },
        leftPage: function () {
            Events.rollTab("left");
        },
        rightPage: function () {
            Events.rollTab();
        },
        closeThisTabs: function () {
            Layout.closeThisTabs();
        },
        closeOtherTabs: function (e) {
            var cls = "LAY-system-pagetabs-remove";
            "all" === e
                ? ($("#eip_app_tabsheader>li:gt(0)").remove(), $("#" + setter.workspace).find(".layeip-tabsbody-item:gt(0)").remove())
                : (
                    $("#eip_app_tabsheader>li").each(function (i, n) {
                        i && i !== Layout.tabsPage.index && (
                            $(n).addClass(cls),
                            Layout.tabsBody(i).addClass(cls)
                        );
                    }),
                    $("." + cls).remove()
                );
        },
        closeAllTabs: function () {
            Events.closeOtherTabs("all"), location.hash = "";
        },
        logout: function () {
            view.confirm({
                content: '确定要退出吗？',
                yes: function (index, layero) {
                    view.exit();
                }
            });
        },
        shade: function () {
            Layout.sideFlexible();
        }
    };
    Layout.on("hash(side)", function (e) {
        var eleMenu = $("#" + menuId),
            eleItemClass = "layui-nav-itemed",
            action = function (items) { Layout.sideFocus(); };
        eleMenu.find("." + eleItemClass).removeClass(eleItemClass), Layout.screen() < 2 && Layout.sideFlexible(), action(eleMenu.children("li"));
    });

    element.on("nav(layeip-system-side-menu)", function (e) { Layout.tabsPage.type = "nav"; });
    element.on("tabDelete(layeip-layout-tabs)", function (e) {
        var tab = $("#eip_app_tabsheader>li.layui-this");
        e.index && Layout.tabsBody(e.index).remove();
        Tabs(tab);
        Layout.delResize();
    });
    element.on("nav(layeip-pagetabs-nav)", function (e) {
        var a = e.parent();
        a.removeClass("layui-this"), a.parent().removeClass("layui-show");
    });

    body.on("click", "#eip_app_tabsheader>li", function () {
        var $this = $(this),
            index = $this.index();
        return Layout.tabsPage.type = "tab",
            Layout.tabsPage.index = index,
            "iframe" === $this.attr("lay-attr") ? Layout.tabsBodyChange(index) : (Tabs($this), Layout.resizeTable());
    });
    body.on("click", "*[layeip-event]", function () {
        var $this = $(this), eventName = $this.attr("layeip-event");
        Events[eventName] && Events[eventName].call(this, $this);
    });
    body.on("click", "*[lay-href]", function () {
        var $this = $(this),
            href = Layout.reviseRouter($this.attr("lay-href"));
        layui.router();
        Layout.tabsPage.elem = $this, location.hash = href;
    });
    exports("layout", Layout);
});