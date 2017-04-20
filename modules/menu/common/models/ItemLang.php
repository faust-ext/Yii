<?php

namespace app\modules\menu\common\models;

use app\modules\core\common\models\Lang;
use Yii;

/**
 * This is the model class for table "{{%menu_items_langs}}".
 *
 * @property integer $item_id
 * @property integer $lang_id
 * @property string $title
 *
 * @property Lang $lang
 * @property Item $item
 */
class ItemLang extends \app\modules\core\common\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_items_langs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lang_id'], 'required'],
            [['item_id', 'lang_id'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'Item ID',
            'lang_id' => 'Lang ID',
            'title' => 'Заголовок',
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
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }
}
