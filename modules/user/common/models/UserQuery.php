<?php

namespace app\modules\user\common\models;

use app\modules\core\common\models\Status;
use yii\db\ActiveQuery;

class UserQuery extends ActiveQuery
{
    public function init()
    {
        parent::init();
        $this->where(['!=', User::tableName() . '.status', Status::ERASED]);
    }

    public function active($state = true)
    {
        $this->andWhere([User::tableName() . '.status' => $state ? Status::ACTIVE : Status::DELETED]);
        return $this;
    }
}