<?php

namespace app\modules\article\common\models;

use app\modules\core\common\components\ActiveRecord;
use app\modules\core\common\behaviors\ImageBehavior;
use app\modules\core\common\behaviors\SoftDeleteBehavior;
use app\modules\core\common\behaviors\TranslationBehavior;
use app\modules\core\common\models\Lang;
use app\modules\user\common\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%articles}}".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $category_id
 * @property integer $author_id
 * @property integer $published_at
 * @property integer $published_until
 * @property string $preview_image
 *
 * @property User $author
 * @property Category $category
 * @property ArticleLang $translation
 *
 * @mixin ImageBehavior
 * @mixin TranslationBehavior
 */
class Article extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%articles}}';
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
            'softDelete'          => [
                'class' => SoftDeleteBehavior::className()
            ],
            'translationBehavior' => [
                'class'              => TranslationBehavior::className(),
                'langModel'          => ArticleLang::className(),
                'langModelAttribute' => 'article_id'
            ],
            'imageBehavior'       => [
                'class'       => ImageBehavior::className(),
                'attributes'  => ['preview_image'],
                'dirName'     => 'articles',
                'deleteEvent' => SoftDeleteBehavior::EVENT_AFTER_ERASE
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'author_id'], 'required'],
            [['created_at', 'updated_at', 'status', 'category_id', 'author_id'], 'integer'],
            [['published_at', 'published_until'], 'date', 'format' => 'dd.MM.yyyy HH:mm:ss'],
            [['preview_image'], 'file', 'extensions' => 'jpeg, jpg, png, gif'],
            ['author_id', 'default', 'value' => Yii::$app->user->id],
            ['status', 'default', 'value' => 1],
            [['is_deleted'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'              => 'ID',
            'created_at'      => 'Дата создания',
            'updated_at'      => 'Дата изменения',
            'status'          => 'Статус',
            'category_id'     => 'Категория',
            'author_id'       => 'Автор',
            'published_at'    => 'Дата публикации',
            'published_until' => 'Дата снятия с публикации',
            'preview_image'   => 'Изображение для списка',
            'title'           => 'Заголовок',
            'categoryTitle'   => 'Категория',
            'authorName'      => 'Автор',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslation()
    {
        return $this->hasOne(ArticleLang::className(),
            ['article_id' => 'id'])->where([ArticleLang::tableName() . '.lang_id' => Lang::getCurrent()->id]);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->published_at    = $this->published_at ? strtotime($this->published_at) : null;
            $this->published_until = $this->published_until ? strtotime($this->published_until) : null;

            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     * @return ArticleQuery
     */
    public static function find()
    {
        return new ArticleQuery(get_called_class());
    }

    public function getViewUrl() {
        return Url::to(['/article/article/view', 'id' => $this->id]);
    }
}
