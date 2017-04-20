<?php

namespace app\modules\core\backend\controllers;

use app\modules\core\backend\components\Controller;
use Yii;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'upload' => [
                'class' => 'app\modules\core\backend\components\CKEditor\FileUploadAction',
                'uploadPath' => '@uploads/',
                'relativePath' => '/uploads/',
            ]

        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
