<?php

namespace app\modules\page\common\models;

use app\modules\core\common\models\Lang;
use Yii;

/**
 * This is the model class for table "pages_langs".
 *
 * @property integer $page_id
 * @property integer $lang_id
 * @property string $title
 * @property string $text
 *
 * @property Page $page
 * @property Lang $lang
 */
class PageLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages_langs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'lang_id', 'text'], 'required'],
            [['page_id', 'lang_id'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'page_id' => 'Page ID',
            'lang_id' => 'Lang ID',
            'title' => 'Заголовок',
            'text' => 'Описание',
            'articul' => 'Артикул',
            'form' => 'Форма выпуска',
            'structure'=> 'Состав',
            'app'=> 'Способ применения',
            'searching'=> 'Клинические исследования'
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
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }
}
