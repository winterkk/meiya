<?php
// 路由规则
return [

	// [
 //                'class' => 'yii\rest\UrlRule',
 //                'controller' => ['v1\controllers'],
 //        ],
        '/' => 'v1/members/show',
        // 'show' => 'v2/default/show',
        // '/' => '',
        // '/pay/notify' => '/pay/show',
        //'v1/users/check-access/<username:\w+>/<password:\w+>' => 'v1/users/check-access',
        //GET方式传参接口
        // 'v1/material/get-demand-list/<batchStatus:\d+>/<timeSequence:\d+>/<page:\d+>/<pageSize:\d+>' => 'v1/material/get-demand-list',  
        // 'v1/material/get-demand-info/<batchId:\d+>' => 'v1/material/get-demand-info',
        // 'v1/material/get-apply-list/<batchStatus:\d+>/<timeSequence:\d+>/<page:\d+>/<pageSize:\d+>' => 'v1/material/get-apply-list',
        // 'v1/material/take-stock-loss/<stockCheckActionId:\w+>/<page:\d+>/<pageSize:\d+>' => 'v1/material/take-stock-loss',
        // 'v1/material/get-basic-stock-list/<goodsSpecId:\w+>/<timeSequence:\d+>/<page:\d+>/<pageSize:\d+>' => 'v1/material/get-basic-stock-list',
        // 'v1/material/get-stock-info/<goodsId:\w+>' => 'v1/material/get-stock-info',
        // 'v1/material/upload-image/<goodsId:\w+>' => 'v1/material/upload-image',
];