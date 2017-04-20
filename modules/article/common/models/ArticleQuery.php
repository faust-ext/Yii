<?php

namespace app\modules\article\common\models;

use app\modules\core\common\models\Status;
use yii\db\ActiveQuery;

class ArticleQuery extends ActiveQuery
{
    public function init()
    {
        parent::init();
        $this->where(['!=', Article::tableName() . '.status', Status::ERASED]);
    }

    public function active($state = true)
    {
        $this->andWhere([Article::tableName() . '.status' => $state ? Status::ACTIVE : Status::DELETED]);
        return $this;
    }
}