<?php

namespace app\modules\article\common\models;

use app\modules\core\common\behaviors\ImageBehavior;
use app\modules\core\common\behaviors\SoftDeleteBehavior;
use app\modules\core\common\behaviors\TranslationBehavior;
use app\modules\core\common\models\Lang;
use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\core\common\components\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%articles_categories}}".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $parent_id
 * @property string $alias
 * @property string $pattern
 * @property string $image
 *
 * @property Article[] $articles
 * @property Category $parent
 * @property Category[] $children
 * @property CategoryLang $translation
 */
class Category extends ActiveRecord
{
    public $indent;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%articles_categories}}';
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
                'langModel'          => CategoryLang::className(),
                'langModelAttribute' => 'category_id'
            ],
            'imageBehavior'       => [
                'class'       => ImageBehavior::className(),
                'dirName'     => 'article-categories',
                'deleteEvent' => SoftDeleteBehavior::EVENT_AFTER_ERASE
            ]
        ];
    }

    public function init()
    {
        $this->on(SoftDeleteBehavior::EVENT_BEFORE_REMOVE, function ($event) {
            if (count($this->articles)) {
                Yii::$app->session->setFlash('error', 'Невозможно удалить категорию: категория содержит статьи.');
                $event->isValid = false;
            } elseif (count($this->children)) {
                Yii::$app->session->setFlash('error', 'Невозможно удалить категорию: категория содержит подкатегории.');
                $event->isValid = false;
            }
        });
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => 1],
            [['alias', 'pattern'], 'required'],
            [['created_at', 'updated_at', 'status', 'parent_id'], 'integer'],
            [['alias', 'pattern'], 'string', 'max' => 30],
            [['image'], 'file', 'extensions' => 'jpeg, jpg, png, gif'],
            [['is_deleted'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'status'     => 'Статус',
            'parent_id'  => 'Родительская категория',
            'alias'      => 'Алиас',
            'pattern'    => 'Шаблон',
            'image'      => 'Изображение',
            'title'      => 'Заголовок',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id'])->active();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslation()
    {
        return $this->hasOne(CategoryLang::className(),
            ['category_id' => 'id'])->where([CategoryLang::tableName() . '.lang_id' => Lang::getCurrent()->id]);
    }

    /**
     * @inheritdoc
     * @return CategoryQuery
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    public static function getDropdown($exclude = [])
    {
        return ArrayHelper::map(
            static::find()
                ->andWhere(['NOT IN', 'id', $exclude])
                ->joinWith(['translation'])
                ->active()
                ->select(['id', 'title'])->all(), 'id', 'translation.title');
    }
}
