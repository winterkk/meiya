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
        'admin' => [
            'class' => 'backend\modules\admin\Module',
        ],
        'rbac' => [
            'class' => 'backend\modules\rbac\Module'
        ],
        'system' => [
            'class' => 'backend\modules\system\Module'
        ],
    ],
    // 别名
    'aliases' => [
        '@admin' => '@backend/modules/admin',
        '@rbac' => '@backend/modules/rbac',
        '@system' => '@backend/modules/system',
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            // 验证cookie
            'enableCookieValidation' => true,
            // 优先接收json数据
            // 'parsers' => [
            //     'application/json' => 'yii\web\JsonParser',
            //     'text/json' => 'yii\web\JsonParser',
            // ],
        ],
        'user' => [
            'identityClass' => 'rbac\models\User',
            'loginUrl' => ['/rbac/user/login'],
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoute' => ['guest'],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false, // 是否执行严格的url解析
            'showScriptName' => false,
            'rules' => $rules,
        ],
        'as access' => [
            'class' => 'rbac\components\AccessControl',
            'allowActions' => [
                'rbac/user/request-password-reset',
                'rbac/user/reset-password'
            ]
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
        ]
    ],
    'params' => $params,
];
