<?php

namespace app\modules\feedback\frontend;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = 'app\modules\feedback\frontend\controllers';

    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules(
            require(__DIR__ . '/config/routes.php'),
            false);

        $app->params['yii.migrations'][] = '@app/modules/feedback/migrations';
    }

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }


    public function getModuleName()
    {
        return 'feedback';
    }

    public function getTitle()
    {
        return 'Обратная связь';
    }

    public function getMenuUrl()
    {
        return [
            'controllers' => [
                'default' => [
                    'actions' => [
                        'index' => [],
                    ]
                ],
            ]
        ];
    }
}
