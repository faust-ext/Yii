<?php

namespace app\modules\article\frontend;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = 'app\modules\article\frontend\controllers';

    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules(
            require(__DIR__ . '/config/routes.php'),
        false);

        $app->params['yii.migrations'][] = '@app/modules/article/migrations';
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
                    'article' => [
                        'actions' => [
                            'index' => [],
                            'category' => [],
                            'view' => [],
                        ]
                    ]
                ]
            ]
        ];
    }


}
