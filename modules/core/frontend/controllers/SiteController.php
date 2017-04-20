<?php

namespace app\modules\core\frontend\controllers;

use app\modules\article\common\models\Article;
use app\modules\article\common\models\Category;
use app\modules\core\common\models\Lang;
use app\modules\menu\common\models\Item;
use app\modules\page\common\models\Mail;
use Yii;
use yii\console\Response;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $news = Article::find()
            ->with(['translation'])
            ->where(['category_id' => 2])
            ->limit(3)
            ->all();

        $presses = Article::find()
            ->with(['translation'])
            ->where(['category_id' => 11])
            ->limit(3)
            ->all();

        $actions = Article::find()
            ->with(['translation'])
            ->where(['category_id' => 10])
            ->limit(3)
            ->all();

        $publics = Article::find()
            ->with(['translation'])
            ->where(['category_id' => 6])
            ->limit(2)
            ->all();

        $product = Article::find()
            ->with(['translation'])
            ->where(['category_id' => 7])
            ->one();

        $intels = Category::find()
            ->with(['translation'])
            ->where(['parent_id' => 14])
            ->limit(3)
            ->all();

        $slider = Article::find()
            ->with(['translation'])
            ->where(['category_id' => 34])
            ->andWhere(['status' => 1])
            ->all();

        $menuItems = Item::find()->all();

        return $this->render('index',
            [
                'news' => $news,
                'presses' => $presses,
                'actions' => $actions,
                'publics' => $publics,
                'product' => $product,
                'intels' => $intels,
                'menuItems' => $menuItems,
                'slider' => $slider,
            ]);
    }

    public function actionSearch($query)
    {
        $connection = Yii::$app->db;
        $rows = $connection->createCommand("
            SELECT * FROM
            (SELECT  category_id AS id, title, description as intro_text, NULL as full_text, alias, pattern, null as menu
            FROM articles_categories_langs
            LEFT JOIN articles_categories
            ON articles_categories.id = articles_categories_langs.category_id
            WHERE title LIKE :query OR description LIKE :query AND status = 1
            UNION
            SELECT article_id AS id, title, intro_text, full_text, null AS menu, NULL AS alias, NULL AS pattern
            FROM articles_langs
            LEFT  JOIN  articles
            ON articles.id = article_id
            WHERE title LIKE :query OR intro_text LIKE :query OR full_text LIKE :query AND status = 1)
            as t
        ", [
            ':query' => '%' . $query . '%',
        ])->queryAll();

        for ($i = 0; $i < count($rows); $i++) {
            if (!(is_null($rows[$i]['alias']))) {
                $category = Category::find()->where(['alias' => $rows[$i]['alias']])->one();
                if (is_null($category->parent_id)) {
                    $rows[$i]['rowaction'] = 'category-list';
                } else
                    $rows[$i]['rowaction'] = 'index';
                while ($category->parent_id != null) {
                    $category = Category::find()->where(['id' => $category->parent_id])->one();
                }

                $rows[$i]['menu'] = $category->alias;
            } else {
                $article = Article::find()->where(['id' => $rows[$i]['id']])->one();
                $category = Category::find()->where(['id' => $article->category_id])->one();

                while ($category->parent_id != null) {
                    $category = Category::find()->where(['id' => $category->parent_id])->one();
                }

                $rows[$i]['menu'] = $category->alias;
            }


        }

        return $this->render('search',
            [
                'rows' => $rows,
                'query' => $query,
            ]
        );
    }

    public function actionMail()
    {
        $model = new Mail();
        if ($model->load(Yii::$app->getRequest()->post())) {
            if ($model->validate()) {
                $text = "Имя: $model->name \n
                Телефон: $model->phone \n
                Эл.почта: $model->email \n
                Сообщение:$model->text";

                Yii::$app->mailer->compose()
                    ->setFrom($model->email)
                    ->setTo('contact@garmonialab.com')
                    ->setSubject('garmonia')
                    ->setTextBody('asd')
                    ->send();


                $success = 'yes';
            } else {
                $success = '';
                foreach ($model->getErrors() as $key => $value) {
                    $success .= $key . ': ' . $value[0] . "\n";
                }

            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            return (["response" => $success]);

        } else {
            return $this->render('index');
        }
    }
}
