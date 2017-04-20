<?php

namespace app\modules\core\common\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "statuses".
 *
 * @property integer $id
 * @property string $title
 */
class Status extends Model
{
    const ACTIVE = 1;
    const DELETED = 2;
    const ERASED = 3;
}
