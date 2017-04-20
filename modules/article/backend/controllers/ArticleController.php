<?php

namespace app\modules\article\backend\controllers;

use Yii;
use app\modules\article\common\models\Article;
use app\modules\article\backend\models\ArticleSearch;
use app\modules\core\backend\components\ARController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends ARController
{
    protected function getModelClass()
    {
        return Article::className();
    }

    protected function getSearchModelClass()
    {
        return ArticleSearch::className();
    }
}
