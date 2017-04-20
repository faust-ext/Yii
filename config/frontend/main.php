<?php

$modules = require(__DIR__ . '/modules.php');

$config = [
    'id' => 'basic',
    'bootstrap' => \yii\helpers\ArrayHelper::merge(['log'], array_keys($modules)),
    'modules' => $modules,
    'components' => [
        'errorHandler' => [
            'errorAction' => 'core/site/error',
        ],
        'assetManager'         => [
            'basePath' => '@webroot/assets',
            'baseUrl'  => '@web/assets',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => ['js/libs/jquery-1.10.2.min.js']
                ]
            ],
        ],
        'urlManager'           => [
            'class' => '\app\modules\core\frontend\components\LangUrlManager',
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'enableStrictParsing' => true,
            'suffix' => '/'
        ],
        'request'              => [
            'baseUrl' => '',
            'class' => '\app\modules\core\frontend\components\LangRequest',
        ],
        'user' => [
            'loginUrl' => '/user/login/'
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
    ],
    'layoutPath' => '@app/modules/core/frontend/views/layouts'
];

$config['bootstrap'][] = function () {
    return Yii::$app->getModule('user');
};

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
