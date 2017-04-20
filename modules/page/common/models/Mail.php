<?php

namespace app\modules\page\common\models;

use Yii;
use app\modules\core\common\components\ActiveRecord;

/**
 * This is the model class for table "mails".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $text
 */
class Mail extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mails';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'text'], 'required'],
            ['email', 'email'],
            [['name', 'email', 'phone', 'text'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'text' => 'Text',
        ];
    }
}
