<?php
namespace app\modules\core\backend\components\actions;

use Yii;
use yii\base\Action;

class UpdateAction extends Action
{
    public $modelClass;

    public function run($id)
    {
        $className = $this->modelClass;
        $model = $className::findOne($id);

    //    var_dump($model); die;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->controller->redirect(['index']);
        }

        return $this->controller->render('update', [
            'model' => $model,
        ]);
    }
}