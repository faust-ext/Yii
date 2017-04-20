<?php

namespace app\modules\feedback\common\models;

use app\modules\core\common\models\Status;
use yii\db\ActiveQuery;

class FeedbackQuery extends ActiveQuery
{
    public function init()
    {
        parent::init();
        $this->where(['!=', Feedback::tableName() . '.status', Status::ERASED]);
    }

    public function active($state = true)
    {
        $this->andWhere([Feedback::tableName() . '.status' => $state ? Status::ACTIVE : Status::DELETED]);
        return $this;
    }
}