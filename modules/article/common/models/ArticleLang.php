<?php

namespace app\modules\article\common\models;

use app\modules\core\common\models\Lang;
use app\modules\core\common\components\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%articles_langs}}".
 *
 * @property integer $article_id
 * @property integer $lang_id
 * @property string $title
 * @property string $intro_text
 * @property string $full_text
 *
 * @property Lang $lang
 * @property Article $article
 */
class ArticleLang extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%articles_langs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lang_id', 'title', 'intro_text', 'full_text'], 'required'],
            [['article_id', 'lang_id'], 'integer'],
            [['intro_text', 'full_text'], 'string'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'article_id' => 'Article ID',
            'lang_id' => 'Lang ID',
            'title' => 'Заголовок',
            'intro_text' => 'Анонс',
            'full_text' => 'Полный текст',
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
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }
}
