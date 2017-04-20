<?php

namespace app\modules\menu\common\models;

use Yii;
use app\modules\core\common\models\Status;
use yii\db\ActiveQuery;

class MenuQuery extends ActiveQuery
{

    public function init()
    {
        parent::init();
        $this->where(['!=', Menu::tableName() . '.status', Status::ERASED]);
    }

    public function active($state = true)
    {
        $this->andWhere([Menu::tableName() . '.status' => $state ? Status::ACTIVE : Status::DELETED]);
        return $this;
    }

}
