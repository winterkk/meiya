<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Admins */
/* @var $form ActiveForm */
?>
<div>
	<?php echo Yii::t('backend-admin','User'); ?>
</div>
<?php $this->beginBlock('layui-form'); ?>
    layui.use(['layer','form'],function(){
    var layer = layui.layer, form = layui.form;
    layer.msg('hello world');
})
<?php $this->endBlock(); ?>
<!-- site-login -->
<?php $this->registerJs($this->blocks['layui-form'], \yii\web\View::POS_END); ?>  