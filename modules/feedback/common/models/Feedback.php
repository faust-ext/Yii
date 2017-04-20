<?php

namespace app\modules\feedback\common\models;

use app\modules\core\common\behaviors\SoftDeleteBehavior;
use app\modules\core\common\models\Lang;
use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\core\common\components\ActiveRecord;

/**
 * This is the model class for table "feedbacks".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $answered_at
 * @property integer $status
 * @property integer $lang_id
 * @property string $name
 * @property string $email
 * @property integer $answerer_id
 * @property string $question
 * @property string $answer
 *
 * @property Lang $lang
 */
class Feedback extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedbacks';
    }

    public function behaviors()
    {
        return [
            [
                'class'      => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            'softDelete' => [
                'class' => SoftDeleteBehavior::className()
            ]
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => 1],
            ['answerer_id', 'default', 'value' => Yii::$app->user->id],
            [['name', 'question', 'answer'], 'required'],
            [['created_at', 'updated_at', 'answered_at', 'status', 'lang_id', 'answerer_id'], 'integer'],
            [['question', 'answer'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'answered_at' => 'Дата ответа',
            'status' => 'Статус',
            'lang_id' => 'Язык',
            'name' => 'Имя',
            'email' => 'Email',
            'answerer_id' => 'Ответчик',
            'question' => 'Вопрос',
            'answer' => 'Ответ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'lang_id']);
    }

    /**
     * @inheritdoc
     * @return FeedbackQuery
     */
    public static function find()
    {
        return new FeedbackQuery(get_called_class());
    }
}
