<?php

namespace app\modules\page\frontend\controllers;


use yii\web\Controller;


class PageController extends Controller
{
    public function actionIndex($alias)
    {
        return $this->render($alias);
    }
}
