<?php

namespace app\modules\menu\common\models;

use app\modules\core\common\behaviors\SoftDeleteBehavior;
use app\modules\core\common\components\MenuInterface;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%menu_menus}}".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property string $title
 *
 * @property Item[] $items
 */
class Menu extends \app\modules\core\common\components\ActiveRecord
{
    public $params;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_menus}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            'softDelete' => [
                'class' => SoftDeleteBehavior::className()
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 1],
            [['status', 'title'], 'required'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['title'], 'string', 'max' => 255],
            ['params', 'safe']
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
            'title' => 'Название',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['menu_id' => 'id'])->active()->orderBy('sort');
    }

    /**
     * @inheritdoc
     * @return MenuQuery
     */
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }

    public static function getDropdown($exclude = [])
    {
        return ArrayHelper::map(
            static::find()
                ->andWhere(['NOT IN', 'id', $exclude])
                ->active()
                ->select(['id', 'title'])->all(), 'id', 'title');
    }

    /**
     * @return array
     * Возвращает массив модулей, которые наследуются от MenuInterface
     */
    public static function getModules()
    {
       /* $modules = Menu::getMenuUrl();
        $moduleNames = [];
        foreach ($modules as $key => $module) {
            $moduleNames[$key] = $module['title'];
        }



        return $moduleNames;*/

        $modules = Yii::$app->modules;

        foreach ($modules as $key => $module)
        {
            if($module instanceof MenuInterface) {
                $moduleNames[$key] = $module->getTitle();
            }
        }


        return $moduleNames;
    }


    /**
     * @return array
     * Возвращает массив с контроллерами, действиями для модулей, которые наследуются от MenuInterface
     */
    public static function getModuleControllers()
    {


        $modules = Yii::$app->modules;


        $data = [];

        foreach ($modules as $module)
        {
            if($module instanceof MenuInterface) {
               // echo $module->id;
               // return $module->getUrlArray();
               // die();
               $data[$module->id] = [
                   'name' => $module->id,
                   'title' => $module->getTitle(),
                   'controllers' => $module->getControllers(),
               ];
            }
        }
        return $data;

    }


}
