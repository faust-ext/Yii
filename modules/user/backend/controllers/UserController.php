<?php

namespace app\modules\user\backend\controllers;

use app\modules\core\backend\components\ARController;
use app\modules\user\backend\models\UserSearch;
use app\modules\user\common\models\User;
use Yii;
use app\modules\user\common\models\LoginForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

class UserController extends ARController
{
    public function behaviors()
    {
        return ArrayHelper::merge([
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                    ],
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
        ], parent::behaviors());
    }

    protected function getModelClass()
    {
        return User::className();
    }

    protected function getSearchModelClass()
    {
        return UserSearch::className();
    }

    public function actionLogin()
    {
        $this->layout = '//login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
