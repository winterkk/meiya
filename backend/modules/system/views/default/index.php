<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\LayuiAsset;
use yii\grid\GridView;
use common\services\CommonService;

LayuiAsset::register($this); 

?>
<blockquote class="layui-elem-quote" style="font-size: 14px;">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
</blockquote>

<div class="system-default-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // search
        // 'filterModel' => $searchModel,
        'options' => ['class' => 'grid-view','style'=>'overflow:auto', 'id' => 'grid'],
        'tableOptions' => ['class' => 'layui-table'],
        // page
        'pager' => [
            'prevPageLabel' => '上一页',
            'nextPageLabel' => '下一页',
            'firstPageLabel' => '首页',
            'lastPageLabel' => '尾页',
            'maxButtonCount' => 5,
        ],
        // 
        'columns' => [
            // 复选框
            // [
            //     'class' => 'yii\grid\CheckboxColumn',
            //     'checkboxOptions' => ['lay-skin'=>'primary','lay-filter'=>'choose'],
            //     'headerOptions' => ['width'=>'50','style'=> 'text-align: center;'],
            //     'contentOptions' => ['style'=> 'text-align: center;']
            // ],
            // 显示序号列
            // ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'ID',
                'attribute' => 'id',
                'format' => 'raw'
            ],
            [
                'label' => '用户名',
                'attribute' => 'username',
                'format' => 'raw'
            ],
            [
                'label' => '手机号',
                'attribute' => 'phone',
                'format' => 'raw'
            ],
            [
                'label' => '邮箱',
                'attribute' => 'email',
                'format' => 'raw'
            ],
            [
                'label' => '头像',
                'attribute' => 'avatar',
                // 'format' => ['images',['width'=>'30px','height'=>'30px']],
                'format' => 'raw',
                'value' => function($data) {
                    return '<img src = "'.CommonService::getImageUrl($data->avatar,\Yii::$app->params['upload']['imageUrl']).'" width = "30px" height="30px"';
                }
            ],
            [
                'label' => '登录IP',
                'attribute' => 'login_ip',
                'format' => 'raw'
            ],
            [
                'label' => '登录时间',
                'attribute' => 'login_at',
                'format' => 'raw'
            ],
            [
                'label' => '状态',
                'attribute' => 'status',
                'format' => 'html',
                'value' => function($data){
                    return $data->status == 1 ? '<font color="green">启用</font>' : ($data->status == 2 ? '<font color="red">禁用</font>' : '<font color="gray">删除</font>');
                },
                'contentOptions' => ['style' => 'text-align:center;']
            ],
            // 操作
            [
                'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function($url, $data, $key){
                        return Html::a('查看', Url::to(['view','id'=>$data->id]), ['class' => "layui-btn layui-btn-xs layui-default-view"]);
                    },
                    'update' => function($url, $data, $key){
                        return Html::a('修改', Url::to(['update','id'=>$data->id]), ['class' => "layui-btn layui-btn-xs layui-btn-normal layui-default-update"]);
                    },
                    'delete' => function($url, $data, $key){
                        return Html::a('删除', Url::to(['delete','id'=>$data->id]), ['class' => 'layui-btn layui-btn-xs layui-btn-danger layui-default-delete']);
                    },
                ],
            ]
        ],
    ]); ?>
</div>
