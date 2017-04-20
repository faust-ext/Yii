<?php

namespace app\modules\page\common\models;

use app\modules\core\common\models\Status;
use yii\db\ActiveQuery;

class PageQuery extends ActiveQuery
{
    public function init()
    {
        parent::init();
        $this->where(['!=', Page::tableName() . '.status', Status::ERASED]);
    }

    public function active($state = true)
    {
        $this->andWhere([Page::tableName() . '.status' => $state ? Status::ACTIVE : Status::DELETED]);
        return $this;
    }
}