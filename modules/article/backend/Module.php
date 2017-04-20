<?php

namespace app\modules\article\backend;
use app\modules\core\common\components\MenuInterface;
use yii\base\BootstrapInterface;
use app\modules\article\common\models\Category;

class Module extends \yii\base\Module implements BootstrapInterface, MenuInterface
{
    public $controllerNamespace = 'app\modules\article\backend\controllers';

    public function bootstrap($app)
    {$app->getUrlManager()->addRules(
            require(__DIR__ . '/config/routes.php'),
            false);
    }

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }


    public function getTitle()
    {
        return 'Динамический раздел';
    }

    public function getControllers()
    {

        $cats = Category::find()
            ->with(['translation'])
            ->where(['status' => 1])
            ->all();

        foreach ($cats as $cat)
        {
            $categoriesMass[$cat->alias] = $cat->translation->title;
        }

        return [
            'article' => [
                'title' => 'Динамическая страница',
                'actions' => [
                    'index' => [
                        'title' => 'Список статей',
                        'params' => [
                            'page' => [
                                'title' => 'Страница',
                                'name' => 'alias',
                                'items' => [
                                    $categoriesMass,
                                ],
                            ],
                        ],
                    ],
                    'category-list' => [
                        'title' => 'Список категорий',
                        'params' => [
                            'category' => [
                                'title' => 'Родительская категория',
                                'name' => 'alias',
                                'items' => [
                                    $categoriesMass,
                                ],
                            ]
                        ]
                    ],
                ],
            ]
        ];
    }

}