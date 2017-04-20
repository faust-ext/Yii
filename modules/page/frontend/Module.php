<?php

namespace app\modules\page\frontend;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = 'app\modules\page\frontend\controllers';

    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules(
            require(__DIR__ . '/config/routes.php'),
            false);

        $app->params['yii.migrations'][] = '@app/modules/page/migrations';
    }

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function getUrlArray()
    {
        return [
            'module' => [
                'controllers' => [
                    'default' => [
                        'pages' => [
                            'index' => [],
                            'view' => [],
                        ]
                    ]
                ]
            ]


        ];
    }


}
