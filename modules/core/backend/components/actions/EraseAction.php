<?php
namespace app\modules\core\backend\components\actions;

use Yii;
use yii\base\Action;

class EraseAction extends Action
{
    public $modelClass;

    public function run($id)
    {
        $className = $this->modelClass;
        $className::findOne($id)->erase();
        return $this->controller->redirect(['index']);
    }
}