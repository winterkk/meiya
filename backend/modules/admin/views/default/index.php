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

LayuiAsset::register($this);
?>
<?php $this->beginPage() ?>
<div class="admin-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <table class="" id="test-table"></table>
</div>
<?php $this->endPage() ?>
<?php
    LayuiAsset::addScript($this, "@web/res/js/test-table.js");
?>
