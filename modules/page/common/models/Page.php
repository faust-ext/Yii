<?php

namespace app\modules\page\common\models;

use app\modules\core\common\behaviors\SoftDeleteBehavior;
use app\modules\core\common\behaviors\TranslationBehavior;
use app\modules\core\common\models\Lang;
use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\core\common\components\ActiveRecord;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property string $alias
 */
class Page extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages';
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
            ],
            'translationBehavior' => [
                'class' => TranslationBehavior::className(),
                'langModel' => PageLang::className(),
                'langModelAttribute' => 'page_id'
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
            [['alias'], 'required'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['alias'], 'string', 'max' => 30]
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
            'status' => 'Статус',
            'alias' => 'Алиас',
            'title' => 'Заголовок'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslation()
    {
        return $this->hasOne(PageLang::className(),
            ['page_id' => 'id'])->where([PageLang::tableName() . '.lang_id' => Lang::getCurrent()->id]);
    }

    /**
     * @inheritdoc
     * @return PageQuery
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }
}
