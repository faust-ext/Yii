<?php

namespace app\modules\core\backend;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = 'app\modules\core\backend\controllers';

    public function bootstrap($app)
    {
        $app->defaultRoute = 'core/site/index';

        $app->getUrlManager()->addRules(
            require(__DIR__ . '/config/routes.php'),
            false);

        $app->params['yii.migrations'][] = '@app/modules/core/migrations';
    }

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
