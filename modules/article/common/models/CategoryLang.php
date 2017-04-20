<?php

namespace app\modules\article\common\models;

use app\modules\core\common\models\Lang;
use app\modules\core\common\components\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%articles_categories_langs}}".
 *
 * @property integer $category_id
 * @property integer $lang_id
 * @property string $title
 * @property string $description
 *
 * @property Langs $lang
 * @property ArticlesCategories $category
 */
class CategoryLang extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%articles_categories_langs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lang_id', 'title'], 'required'],
            [['category_id', 'lang_id'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'lang_id' => 'Lang ID',
            'title' => 'Заголовок',
            'description' => 'Описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ArticlesCategories::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'lang_id']);
    }
}
