<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$db = require(__DIR__ . '/common/db.php');
$modules = require(__DIR__ . '/frontend/modules.php');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => \yii\helpers\ArrayHelper::merge(['log', 'gii'], array_keys($modules)),
    'controllerNamespace' => 'app\commands',
    'modules' => \yii\helpers\ArrayHelper::merge([
        'gii' => 'yii\gii\Module',
    ],$modules),
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'controllerMap' => [
        'migrate'=>[
            'class' => 'dmstr\console\controllers\MigrateController',
            'migrationTable' => '{{migrations}}',
        ]
    ],
];
