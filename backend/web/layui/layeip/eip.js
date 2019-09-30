layui.extend({
    setter: "eip.setter",
    viewer: "eip.viewer",
    layout: "eip.layout",
    formSelects: "formSelects-v4"
}).define(["setter", "layout", 'laydate', 'form', 'formSelects'], function (exports) {
    var $ = layui.jquery,
        setter = layui.setter,
        layout = layui.layout,
        view = layui.viewer,
        tabs = layout.tabsPage,
        container = view(setter.container),
        element = layui.element,
        form = layui.form,
        tabfilter = "layeip-layout-tabs";

    //扩展表单验证规则
    form.verify({
        //最大长度验证
        maxlen: function (value, item) { //value：表单的值、item：表单的DOM对象
            var max = $(item).attr('lay-maxlen') || setter.maxLength;
            if (value.length > max) {
                return '输入内容不可超过 ' + max +' 个字符。';
            }
        }
    });

    var render = function () {
        var router = layui.router(),
            path = router.path,
            url = layout.reviseRouter(router.href || path.join('/'));
        path.length || (path = [""]), "" === path[path.length - 1] && (path[path.length - 1] = setter.pages.console);

        if (tabs.type === "tab" && ("/" !== url || setter.pages.console === url && layout.tabsBody().html())) {
            layout.tabsBodyChange(tabs.index);
        } else {
            view().render(path.join("/"))
                .then(function (response) {
                    var opened = false, lis = $("#eip_app_tabsheader>li");
                    lis.each(function (i) {
                        var $this = $(this), id = $this.attr("lay-id");
                        id === url && (opened = true, tabs.index = i);
                    });
                    url !== layout.reviseRouter(setter.pages.console) && (
                        opened || (
                            $("#"+ setter.workspace).append('<div class="layeip-tabsbody-item layui-show"></div>'),
                            tabs.index = lis.length,
                            element.tabAdd(tabfilter, { title: "<span>" + (response.title || "新标签页") + "</span>", id: url, attr: router.href })
                        )
                    );
                    this.container = layout.tabsBody(tabs.index);
                    this.container.scrollTop(0);
                    element.tabChange(tabfilter, url);
                    layout.tabsBodyChange(tabs.index);
                })
                .done(function (response) {

                });
        }
    };

    var start = function () {
        var router = layui.router(),
            url = layout.reviseRouter(router.path.join('/'));
        if (url === setter.pages.login) {
            container.render(router.path.join("/")).done(function () { layout.pageType = "alone"; });
        } else {
            "console" === layout.pageType
                ? render()
                : container.render(setter.pages.layout).done(function () {
                    render();
                    layui.element.render();
                    layout.screen() < 2 && layout.sideFlexible();
                    layout.pageType = "console";
                });
        }
    };
    start();
    window.onhashchange = function () {
        render();
        layui.event.call(this, setter.modName, "hash({*})", layui.router());
    };
    exports("eip", { render: render });
});