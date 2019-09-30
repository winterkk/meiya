layui.define(['laytpl', 'layer', 'element', 'util'], function (exports) {
    var setter = {
        version: "1.0." + Math.random() // EIP组件版本
        , container: 'eip-app'          // 页面布局容器ID
        , workspace: 'eip_app_body'     // 工作区容器ID
        , domain: 'http://ui.xmeip.com' // 站点域名
        , application: 'webui'          // 站点虚拟目录
        , name: "EIP Layui"             // 系统名称
        , base: layui.cache.base        // 记录组件文件夹所在路径
        , debug: true                   // 是否开启调试模式
        , tableName: 'xm_eip'           // 本地存储表名
        , modName: "EIPMOD"             // 模块事件名
        , maxLength: 100                // 默认文半框输入最大长度

        //服务配置
        , services: {
            dataServer: 'https://dev.houtai.api.1jujube.com',
            fileServer: 'https://dev.houtai.api.1jujube.com/banner/upload'  //文件上传服务接口
        }

        //自定义系统内置视图路径
        , pages: {
            layout: "pages/layout.html",
            login: "pages/login.html",
            console: "pages/welcome.html",
            _404: "pages/404.html",
            error: "pages/error.html"
        }

        //自定义请求字段
        , request: {
            tokenName: 'access_token'   //自动携带 token 的字段名。可设置 false 不携带。
        }

        //自定义响应字段
        , response: {
            statusName: 'code'          //数据状态的字段名称
            , statusCode: {
                ok: 0                   //数据状态一切正常的状态码
                , unlogged: 1001        //未登录状态失效的状态码
            }
            , msgName: 'msg'            //状态信息的字段名称
            , dataName: 'data'          //数据详情的字段名称
        }
    };
    exports("setter", setter);
});