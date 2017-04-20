<?php
namespace app\modules\core\backend\components\actions;

use app\modules\core\common\components\ActiveRecord;
use Yii;
use yii\base\Action;
use yii\base\Exception;

class CreateAction extends Action
{
    public $modelClass;

    public function run()
    {
        $className = $this->modelClass;
        /* @var $model ActiveRecord */
        $model = new $className;

        $model->initDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->controller->redirect(['index']);
        }
        
        return $this->controller->render('create', [
            'model' => $model,
        ]);
    }
}