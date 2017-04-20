<?php

namespace app\modules\menu\backend;

use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = 'app\modules\menu\backend\controllers';

    public function bootstrap($app)
    {
            $app->getUrlManager()->addRules(
                require(__DIR__ . '/config/routes.php'),
                false);
    }

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
