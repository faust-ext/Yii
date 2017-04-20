<?php

$modules = require(__DIR__ . '/modules.php');

$config = [
    'id' => 'basic',
    'bootstrap' => \yii\helpers\ArrayHelper::merge(['log'], array_keys($modules)),
    'modules' => $modules,
    'aliases' => [
        '@core' => '@app/modules/core/backend',
        '@uploads' => '@app/web/frontend/uploads'
    ],
    'components' => [
        'view' => [
            'class' => 'app\modules\core\backend\components\View',
        ],
        'errorHandler' => [
            'errorAction' => 'core/site/error',
        ],
        'urlManager'           => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'enableStrictParsing' => true,
            'suffix' => '/'
        ],
        'request'              => [
            'baseUrl' => '/backend',
        ],
        'user' => [
            'loginUrl' => '/backend/user/login/'
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
        'formatter' => [
            'dateFormat' => 'd-m-Y',
            'datetimeFormat' => 'php:d.m.Y H:i:s',
        ]
    ],
    'layoutPath' => '@core/views/layouts'
];

$config['bootstrap'][] = function () {
    return Yii::$app->getModule('user');
};

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'backendCrud' => [
                'class' => 'app\modules\core\backend\generators\crud\Generator',
            ],
            'langModel' => [
                'class' => 'app\modules\core\backend\generators\model\Generator',
            ],
            'broModule' => [
                'class' => 'app\modules\core\backend\generators\module\Generator',
            ],
        ],
    ];
}

return $config;
