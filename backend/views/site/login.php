<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->registerCssFile('@web/css/layui.css');
$this->registerJsFile('@web/js/layui.js');

/* @var $this yii\web\View */
/* @var $model common\models\Admins */
/* @var $form ActiveForm */
?>
<?php $this->beginBlock('layui-form'); ?>
    $(function(){
        layui.use(['layer','form'],function(){
            var layer = layui.layer,
            form = layui.form;
            layer.msg('hello world!');
        })
    });
    
<?php $this->endBlock(); ?>
<!-- site-login -->