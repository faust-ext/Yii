<?php

namespace app\modules\page\backend;

use app\modules\core\common\components\MenuInterface;
use app\modules\page\common\models\Page;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface, MenuInterface
{
    public $controllerNamespace = 'app\modules\page\backend\controllers';

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

    public function getTitle()
    {
        return 'Текстовый раздел';
    }

    public function getControllers()
    {
        $pages = Page::find()
            ->with(['translation'])
            ->where(['status' => 1])
            ->all();

        foreach ($pages as $page)
        {
            $pagesMass[$page->alias] = $page->translation->title;
        }

        return [
            'page' => [
                'title' => 'Статическая страница',
                'actions' => [
                    'index' => [
                        'title' => 'Текстовая страница',
                        'params' => [
                            'alias' => [
                                'title' => 'id страницы',
                                'name' => 'alias',
                                'items' => [$pagesMass],
                            ],
                        ],
                    ],
                  /*  'recycle-bin' => [
                        'title' => 'Корзина',
                        'params' => [],
                    ],
                    'create' => [
                        'title' => 'Создание',
                    ],
                    'update' => [
                        'title' => 'Изменение',
                    ],*/
                ]
            ],
        ];
    }
}
