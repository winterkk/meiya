<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\LayuiAsset;
use yii\grid\GridView;
use common\services\CommonService;
use backend\models\BImage;
use backend\models\BArtClass;
use backend\models\BArtStyle;

LayuiAsset::register($this); 

?>
<blockquote class="layui-elem-quote" style="font-size: 14px;">
    <?php  echo $this->render('_search', ['model' => $model]); ?>
</blockquote>
<div class = "system-art-index">
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'options' => ['class' => 'grid-view', 'style'=>'overflow:auto', 'id'=>'art-grid'],
		'tableOptions' => ['class' => 'layui-table'],

		'pager' => [
			'prevPageLabel' => '上一页',
			'nextPageLabel' => '下一页',
			'firstPageLabel' => '首页',
			'lastPageLabel' => '尾页',
			'maxButtonCount' => 5,
		],

		'columns' => [
			[
				'label' => 'ID',
				'attribute' => 'id',
				'format' => 'raw',
			],
			[
				'label' => '名称',
				'attribute' => 'title',
				'format' => 'raw',
			],
			[
				'label' => '编号',
				'attribute' => 'art_no',
				'format' => 'raw',
			],
			[
				'label' => '价格',
				'attribute' => 'current_price'
			],
			[
				'label' => '图片',
				'attribute' => 'cover_img',
				'format' => 'raw',
				'value' => function($i){
					$coverImg = $i->cover_img;
					$image = BImage::findOne($coverImg);
					$img = CommonService::getImageUrl($image->path,\Yii::$app->params['upload']['imageUrl']);
					return '<img src = "'.$img.'" width = "30px" height="30px"';
				}
			],
			[
				'label' => '宽高',
				'attribute' => 'real_height',
				'format' => 'raw',
				'value' => function($i){
					return ($i->real_width / 10) . 'cm * ' . ($i->real_height / 10) . 'cm';
				}
			],
			[
				'label' => '类目',
				'attribute' => 'class_id',
				'format' => 'raw',
				'value' => function($i){
					$classItem = BArtClass::getArtClasses();
					return isset($classItem[$i->class_id]) ? $classItem[$i->class_id]->title : '';
				}
			],
			[
				'label' => '样式',
				'attribute' => 'style_id',
				'format' => 'raw',
				'value' => function($i){
					$styleItem = BArtStyle::getArtStyles();
					return isset($styleItem[$i->style_id]) ? $styleItem[$i->style_id]->title : '';
				}
			],
			
		],
	]); ?>
</div>