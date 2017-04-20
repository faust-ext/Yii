<?php
namespace app\modules\core\backend\components\actions;

use Yii;
use yii\base\Action;

class RestoreAction extends Action
{
    public $modelClass;

    public function run($id)
    {
        $className = $this->modelClass;
        $className::findOne($id)->restore();
        return $this->controller->redirect(['index']);
    }
}