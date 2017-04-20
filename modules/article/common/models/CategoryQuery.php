<?php

namespace app\modules\article\common\models;

use app\modules\core\common\models\Status;
use yii\db\ActiveQuery;

class CategoryQuery extends ActiveQuery
{
    public $isEmpty = true;

    public function init()
    {
        parent::init();
        $this->where(['!=', Category::tableName() . '.status', Status::ERASED]);
    }

    public function active($state = true)
    {
        $this->andWhere([Category::tableName() . '.status' => $state ? Status::ACTIVE : Status::DELETED]);
        return $this;
    }
}