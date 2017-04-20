<?php
namespace app\modules\core\backend\components\actions;

use Yii;
use yii\base\Action;

class DeleteAction extends Action
{
    public $modelClass;

    public function run($id)
    {
        $className = $this->modelClass;
        $className::findOne($id)->delete();
        return $this->controller->redirect(['index']);
    }
}