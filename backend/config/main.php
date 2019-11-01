<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$rules = require __DIR__ . '/rules.php';

return [
    'id' => 'app-backend',
    'name' => 'meiya erp',
    'basePath' => dirname(__DIR__),
    'language' => 'zh_CN',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    // 默认路由
    'defaultRoute' => 'site/index',
    // 模块
    'modules' => [
        'system' => [
            'class' => 'backend\modules\system\Module'
        ],
        // rbac admin
        'admin' => [
            'class' => 'mdm\admin\Module'
        ]
    ],
    // 别名
    'aliases' => [
        '@system' => '@backend/modules/system',
        '@mdm/admin' => '@vendor/mdmsoft/yii2-admin'
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            // 验证cookie
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true
            // 优先接收json数据
            // 'parsers' => [
            //     'application/json' => 'yii\web\JsonParser',
            //     'text/json' => 'yii\web\JsonParser',
            // ],
        ],
        'user' => [
            'identityClass' => 'common\models\Users',
            'loginUrl' => ['/site/login'],
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false, // 是否执行严格的url解析
            'showScriptName' => false,
            'rules' => $rules,
        ],
        // i18n配置
        'i18n' => [
            'translations' => [
                'backend-admin' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en',
                    'basePath' => '@backend/messages',
                ]
            ]
        ],
        // adminLTE view
        // 'view' => [
        //     'theme' => [
        //         'pathMap' => [
        //             '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
        //         ],
        //     ],
        // ],
        // adminLTE skin
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-black',
                ],
            ],
        ],
    ],
    'params' => $params,

    // 允许访问
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'admin/*'
        ]
    ],
];
