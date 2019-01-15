<?php
// params
$params = array_merge(
    // require __DIR__ . '/../../common/config/params.php',
    // require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
// rules
$rules = require __DIR__ . '/rules.php';

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            // 版本控制
            'class' => 'api\modules\v1\Module'
        ],
    ],
     // 时区
    'charset' => 'utf-8',
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    // 
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            // 不验证cookie
            'enableCookieValidation' => false,
            // 优先接收json数据
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the api
            'name' => 'advanced-api',
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
        // 路由
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false, // 是否执行严格的url解析
            'showScriptName' => false,
            'rules' => $rules,
        ],
        
    ],
    'params' => $params,
];
