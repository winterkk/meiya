<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use backend\assets\LayuiAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
LayuiAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="layui-layout-body">
<?php $this->beginBody() ?>
<div id="MY_app">
    <div class="layui-layout layui-layout-admin">
        <!--头部-->
        <div class="layui-header">
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layadmin-flexible">
                    <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                        <i class="layui-icon layui-icon-shrink-right"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs">
                    <a href="#" layadmin-event="flexible" targe="_blank" title="前台">
                        <i class="layui-icon layui-icon-website"></i>
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;" layadmin-event="refresh" title="刷新">
                        <i class="layui-icon layui-icon-refresh-3"></i>
                    </a>
                </li>
                <span class="layui-nav-bar"></span>
            </ul>
            <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
                <li class="layui-nav-item">
                    <a href="#" layadmin-event="message" lay-text="消息中心">
                        <i class="layui-icon layui-icon-notice"></i>
                        <span class="layui-badge-dot"></span>
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;">
                        <cite>dzzz</cite>
                        <span class="layui-nav-more"></span>
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a href="#">基本资料</a></dd>
                        <dd><a href="#">修改密码</a></dd>
                        <hr>
                        <dd layadmin-event="logout" style="text-align: center;"><a>退出</a></dd>
                    </dl>
                </li>
            </ul>
    
        

        </div>
        <!--侧边菜单-->
        <div class="layui-side layui-side-menu">
            <div class="layui-side-scroll">
                <div class="layui-logo" lay-href="<?=Yii::getAlias('@web')?>">
                    <span>myadmin</span>
                </div>
                <?php echo $this->render('@app/views/layouts/menu.php', ['allMenu'=>[]]); ?>
            </div>
        </div>
        <!--页面标签-->
        <div class= "layadmin-pagetabs">
            



        <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-down">
          <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
            <li class="layui-nav-item" lay-unselect="">
              <a href="javascript:;"><span class="layui-nav-more"></span></a>
              <dl class="layui-nav-child layui-anim-fadein">
                <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
              </dl>
            </li>
          <span class="layui-nav-bar"></span></ul>
        </div>
        <div class="layui-tab" lay-unauto="" lay-allowclose="true" lay-filter="layadmin-layout-tabs">
          <ul class="layui-tab-title" id="LAY_app_tabsheader">
            <li lay-id="home/console.html" lay-attr="home/console.html" class="layui-this"><i class="layui-icon layui-icon-home"></i><i class="layui-icon layui-unselect layui-tab-close">ဆ</i></li>
          </ul>
        </div>
    



        </div>
        <!--主体-->
        <div class="layui-body">
            


            <div class="layadmin-tabsbody-item layui-show">
            <!---<iframe src="home/console.html" frameborder="0" class="layadmin-iframe"></iframe>--->
            </div>



        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
