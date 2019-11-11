<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div class="art-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'form-inline'],
		'fieldConfig' => [
		   'template' => '<div class="layui-inline">{label}：<div class="layui-input-inline">{input}</div></div><span class="help-block" style="display: inline-block;">{hint}</span>',
	   ],
    ]); ?>

    <?= $form->field($model, 'id')->textInput(['class'=>'layui-input search_input']) ?>
    <?= $form->field($model, 'title')->textInput(['class'=>'layui-input search_input']) ?>
    <?= $form->field($model, 'art_no')->textInput(['class'=>'layui-input search_input']) ?>
    <?= $form->field($model, 'class_id')->textInput(['class'=>'layui-input search_input']) ?>
    <?= $form->field($model, 'style_id')->textInput(['class'=>'layui-input search_input']) ?>
    <?= $form->field($model, 'cont_id')->textInput(['class'=>'layui-input search_input']) ?>
    <?= $form->field($model, 'status')->textInput(['class'=>'layui-input search_input']) ?>

    <div class="form-group">
        <?= Html::submitButton('查找', ['class' => 'layui-btn layui-btn-normal']) ?>
        <?= Html::button('添加', ['class' => 'layui-btn layui-default-add']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
