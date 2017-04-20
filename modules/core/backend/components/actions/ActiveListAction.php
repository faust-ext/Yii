<?php
namespace app\modules\core\backend\components\actions;

use Yii;
use yii\base\Action;
use app\modules\core\common\models\Status;

class ActiveListAction extends Action
{
    public $searchModel;
    public $view;
    public $active = true;

    public function run()
    {
        $model = new $this->searchModel;
        $dataProvider = $model->search(Yii::$app->request->queryParams);
       // var_dump($this->searchModel);
        if ($this->searchModel == 'app\modules\menu\backend\models\ItemSearch' || $this->searchModel == 'app\modules\article\backend\models\CategorySearch')
            $dataProvider->isActive = $this->active? Status::ACTIVE : Status::DELETED;
        else
            $dataProvider->query->active($this->active);


        return $this->controller->render($this->view, [
            'searchModel' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }
}