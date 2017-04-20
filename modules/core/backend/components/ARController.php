<?php

namespace app\modules\core\backend\components;

use Yii;
use app\modules\core\backend\components\actions\ActiveListAction;
use app\modules\core\backend\components\actions\CreateAction;
use app\modules\core\backend\components\actions\DeleteAction;
use app\modules\core\backend\components\actions\EraseAction;
use app\modules\core\backend\components\actions\RestoreAction;
use app\modules\core\backend\components\actions\UpdateAction;

abstract class ARController extends Controller
{
    /* Класс модели для action'ов */
    abstract protected function getModelClass();

    /* Класс модели поиск для index и recycle */
    abstract protected function getSearchModelClass();

    public function actions()
    {
        return [
            'index'       => [
                'class'       => ActiveListAction::className(),
                'searchModel' => $this->getSearchModelClass(),
                'view'        => 'index'
            ],
            'recycle-bin' => [
                'class'       => ActiveListAction::className(),
                'searchModel' => $this->getSearchModelClass(),
                'active'      => false,
                'view'        => 'recycle-bin'
            ],
            'create'      => [
                'class'      => CreateAction::className(),
                'modelClass' => $this->getModelClass()
            ],
            'update'      => [
                'class'      => UpdateAction::className(),
                'modelClass' => $this->getModelClass()
            ],
            'delete'      => [
                'class'      => DeleteAction::className(),
                'modelClass' => $this->getModelClass()
            ],
            'erase'       => [
                'class'      => EraseAction::className(),
                'modelClass' => $this->getModelClass()
            ],
            'restore'     => [
                'class'      => RestoreAction::className(),
                'modelClass' => $this->getModelClass()
            ]
        ];
    }
}