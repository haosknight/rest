<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'aliases' => [
        '@api' => dirname(dirname(__DIR__)) . '/api',
    ],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['192.168.150.16'] // adjust this to your needs
        ],
        'v1' => [
            'class' => 'app\modules\v1\apiV1Module',
        ],
    ],
    'components' => [
        'request' => [
            'baseUrl' => '/api',
            'csrfParam' => '_csrf-api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'login' => 'site/login',
                'v1/task/<id:\d+>' => 'v1/task/index',
                'v1/task' => 'v1/task/index',
                'v1/task/search' => 'v1/task/search',
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/task']],
            ],
        ],
    ],
    'params' => $params,
];
