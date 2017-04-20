<?php

namespace app\modules\feedback\backend;

use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = 'app\modules\feedback\backend\controllers';

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
}
