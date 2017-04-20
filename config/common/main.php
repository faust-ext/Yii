<?php

return [
    'basePath' => dirname(dirname(__DIR__)),
    'language' => 'ru-RU',
    'components' => [
        'db' => require(__DIR__ . '/db.php'),
        'cache' => [
            'class' => 'yii\caching\DummyCache',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'nbk22tczeNRweoP6GCO3XZs4_KHpUCp4',
        ],
        'user' => [
            'identityClass' => 'app\modules\user\common\models\User',
            'enableAutoLogin' => true
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
