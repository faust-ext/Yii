<?php

namespace app\modules\user\frontend;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = 'app\modules\user\frontend\controllers';

    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules(
            require(__DIR__ . '/config/routes.php'),
        false);

        $app->params['yii.migrations'][] = '@app/modules/user/migrations';
    }

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function getModuleName()
    {
        return 'user';
    }

    public function getTitle()
    {
        return 'Пользователь';
    }

    public function getMenuUrl()
    {
        return [
            'controllers' => [
                'user' => [
                    'actions' => [
                        'login' => [],
                        'logout' => [],
                    ]
                ],
                'update' => 'update',
            ]
        ];
    }
}
