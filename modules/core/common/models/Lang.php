<?php

namespace app\modules\core\common\models;

use Yii;
use app\modules\core\common\components\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%langs}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $locale
 * @property string $prefix
 */
class Lang extends ActiveRecord
{
    //Переменная, для хранения текущего объекта языка
    private static $_current = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%langs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 30],
            [['locale'], 'string', 'max' => 5],
            [['prefix'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'locale' => 'Locale',
            'prefix' => 'Prefix',
        ];
    }

    /**
     * Имя для языка
     * @return string
     */
    public function getLangPrefix()
    {
        if ($this->prefix == self::getDefaultLang()->prefix)
        {
            return '';
        }
        else
        {
            return '/'.$this->prefix;
        }
    }

    /**
     * Получение текущего объекта языка
     * @return array|Lang|null
     */
    static function getCurrent()
    {
        if (self::$_current === null)
        {
            self::$_current = self::getDefaultLang();
        }
        return self::$_current;
    }

    /**
     * Установка текущего объекта языка и локаль пользователя
     * @param null $name
     */
    static function setCurrent($name = null)
    {
        $language           = self::getLangByName($name);
        self::$_current     = ($language === null) ? self::getDefaultLang() : $language;
        Yii::$app->language = self::$_current->locale;
    }

    /**
     * Получения объекта языка по умолчанию
     * @return array|null|Lang
     */
    static function getDefaultLang()
    {
        if(Yii::$app->session->has('default_lang_' . Yii::$app->id))
            $model = Yii::$app->session->get('default_lang_' . Yii::$app->id);
        else {
            $model = static::find()->where('locale = :locale', [':locale' => Yii::$app->language])->one();
            Yii::$app->session->set('default_lang_' . Yii::$app->id, $model);
        }
        return $model;
    }

    /**
     * Получения объекта языка по буквенному идентификатору
     * @param null $name
     * @return array|null|Lang
     */
    static function getLangByName($name = null)
    {
        if ($name === null)
        {
            return null;
        }
        else
        {
            $language = Yii::$app->cache->get('M' . static::className() . 'getLangByName_name=' . $name);

            if($language === false)
            {
                $language = Lang::find()->where('prefix = :prefix', [':prefix' => $name])->one();
                Yii::$app->cache->set('M' . static::className() . 'getLangByName_name=' . $name, $language);
            }

            if ($language === null)
            {
                return null;
            }
            else
            {
                return $language;
            }
        }
    }

    public static function getList()
    {

        $list = Yii::$app->cache->get('M' . static::className() . 'getList');
        if($list === false)
        {
            $list = static::find()->all();
            Yii::$app->cache->set('M' . static::className() . 'getList', $list, 3600);
        }

        return $list;
    }

    public static function getDropdown($exclude = [])
    {
        return ArrayHelper::map(
            static::find()
                ->andWhere(['NOT IN', 'id', $exclude])
                ->select(['id', 'title'])->all(), 'id', 'title');
    }

    public static function t($message, $params = [], $language = null)
    {
        return Yii::t('main', $message, $params, $language ?: static::getCurrent()->id);
    }
}
