<?php

namespace app\modules\menu\common\models;

use Yii;
use app\modules\core\common\behaviors\SoftDeleteBehavior;
use app\modules\core\common\behaviors\TranslationBehavior;
use yii\behaviors\TimestampBehavior;
use app\modules\core\common\models\Lang;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%menu_items}}".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $menu_id
 * @property integer $sort
 * @property integer $parent_id
 * @property string $url
 *
 * @property Menu $menu
 * @property ItemLang $translation
 * @property Lang[] $langs
 */
class Item extends \app\modules\core\common\components\ActiveRecord
{
    public $indent;
    public $module_id;
    public $controller_id;
    public $action_id;
    public $params;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_items}}';
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
                'langModel'          => ItemLang::className(),
                'langModelAttribute' => 'item_id'
            ]
        ];
    }

    public function init()
    {
        $this->on(SoftDeleteBehavior::EVENT_BEFORE_REMOVE, function ($event) {
        });
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 1],
            [['sort'], 'default', 'value' => 500],
            [['status', 'menu_id', 'sort', 'url', 'module_id', 'controller_id', 'action_id'], 'required'],
            [['created_at', 'updated_at', 'status', 'menu_id', 'sort', 'parent_id'], 'integer'],
            [['url'], 'string'],
            [['module_id', 'controller_id', 'action_id', 'params'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => 'Меню',
            'menu' => 'Меню',
            'sort' => 'Порядок сортировки',
            'parent_id' => 'Родительский элемент',
            'url' => 'Ссылка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'status' => 'Статус',
            'title' => 'Заголовок',
            'module_id' => 'Модуль',
            'controller_id' => 'Контроллер',
            'action_id' => 'Действие',
            'params' => 'Параметры',
        ];
    }

    public function getChildren()
    {
        return $this->hasMany(self::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemLangs()
    {
        return $this->hasMany(ItemLang::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangs()
    {
        return $this->hasMany(Lang::className(), ['id' => 'lang_id'])->viaTable('{{%menu_items_langs}}', ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslation()
    {
        return $this->hasOne(ItemLang::className(),
            ['item_id' => 'id'])->where([ItemLang::tableName() . '.lang_id' => Lang::getCurrent()->id]);
    }

    /**
     * @inheritdoc
     * @return ItemQuery
     */
    public static function find()
    {
        return new ItemQuery(get_called_class());
    }

    public function afterFind()
    {
        parent::afterFind();
        //if($this->scenario == 'update')
            $this->parseUrl();
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

    public function findParent($menu, $parent_id)
    {
        foreach ($menu as $item)
        {
            if ($item->id == $parent_id) {
                if ($item->parent_id != null) {
                    $mainParent = $this->findParent($menu, $item->parent_id);
                } else {
                    $mainParent = $parent_id;

                }
            }
        }
        return $mainParent;
    }


    public function createUrl()
    {
        if(is_array($this->params)) {
            $url[] = "/$this->module_id/$this->controller_id/$this->action_id";  //ссылка вида модуль/контроллер/действие


          //  var_dump($this->params); die;
            if ($this->parent_id !== '')
            {
                $menu = Item::find()->active()->all();
                foreach ($menu as $item) {
                    if ($item->id == $this->parent_id) {
                        if ($item->parent_id !== null) {
                            $m = explode(":", $item->url);
                            $menuUrl = str_replace(["'", '"', '}', ',', 'menu'], '', $m[3]);
                            echo $menuUrl . "\n";
                            $subUrl = str_replace(["'", '"', '}', ',', 'menu'], '', $m[2]);
                            echo $subUrl . "\n";
                            $this->params['menu'] = $menuUrl . "/" . $subUrl;
                        }
                        else{
                            $m = explode(":", $item->url);
                            $subUrl = str_replace(["'", '"', '}', ',', 'menu'], '', $m[2]);
                            $this->params['menu'] = $subUrl;
                        }
                    }

                }
            }
           /* if ($this->parent_id !== '')
            {
                $menu = Item::find()->active()->all();
                $main_parent = $this->findParent($menu, $this->parent_id);

            }
            else
            {
                $main_parent = $this->id;
            }*/

           // echo $main_parent; die;
          //  $this->searchMenuTitleById($main_parent);
           /* switch($main_parent)
            {
                case 6:
                    $this->params['menu'] = 'leadership';
                    break;
                case 8:
                    $this->params['menu'] = 'peptides';
                    break;
                case 10:
                    $this->params['menu'] = 'cosmetics';
                    break;
                case 11:
                    $this->params['menu'] = 'publics';
                    break;
                case 12:
                    $this->params['menu'] = 'contacts';
                default:
                    break;
            }*/

            $url = array_merge($url, $this->params); //массив параметров
           // var_dump($url); die;
            return Json::encode($url);
        } else {
            return [];
        }
    }

    public function parseUrl()
    {
        $url = Json::decode($this->url);

        if (!is_array($url[0])) {
            $uri = $url[0];
            // var_dump($uri); die;

            $temp = explode('/', $uri); //строку  модуль/контроллер/действие преобразуем в массив
            // var_dump($temp); die;
            $flag = true;
            if (isset($temp[1]) && isset($temp[2]) && isset($temp[3])) //проверки на ошибки
            {
                $data = Menu::getModuleControllers();

                $this->module_id = $temp[1];

                $this->controller_id = $temp[2];
                $this->action_id = $temp[3];

                foreach ($url as $key => $param) {
                    if ($key == 0) {
                        continue;
                    }
                    if (!array_key_exists($key,
                        $data[$temp[1]]['controllers'][$temp[2]]['actions'][$temp[3]]['params'])
                    ) {
                        if (!in_array($param, $data[$temp[1]]['controllers'][$temp[2]]['actions'][$temp[3]]['params'])
                        ) {
                            $flag = false;
                        }
                    }

                }
                if ($flag) {
                    $this->params = $url;
                }
            }
        }


    }

    public function beforeValidate()
    {
        if(parent::beforeValidate()) {
            $this->url = $this->createUrl();
            return true;
        }
        return false;
    }

    public function getUrlTo()
    {
        $url = Url::to(Json::decode($this->url));

        return $url;
    }


}
