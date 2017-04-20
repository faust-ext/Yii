<?php

namespace app\modules\menu\common\models;

use Yii;
use app\modules\core\common\models\Status;
use yii\db\ActiveQuery;

class ItemQuery extends ActiveQuery
{
    public $isEmpty = true;

    public function init()
    {
        parent::init();
        $this->where(['!=', Item::tableName() . '.status', Status::ERASED]);
    }

    public function active($state = true)
    {
        $this->andWhere([Item::tableName() . '.status' => $state ? Status::ACTIVE : Status::DELETED]);
        return $this;
    }

    public function root()
    {
        $this->andWhere(Item::tableName() . '.parent_id IS NULL');
        return $this;
    }

}
