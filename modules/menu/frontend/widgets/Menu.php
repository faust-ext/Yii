<?php

namespace app\modules\menu\frontend\widgets;

use app\modules\menu\common\models\Item;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Menu extends \yii\widgets\Menu {
    public $menu_id;
    public $parent_id;
    public $level;

    public function init()
    {

        /* @var $menu \app\modules\menu\common\models\Menu */
        $menu = \app\modules\menu\common\models\Menu::find()->where(['id' => $this->menu_id])->active()->with('items')->one();


        $subItems = Item::find()->where(['menu_id' => $this->menu_id])->active()->orderBy('sort')->all();
        $this->items = $this->searchChild($this->parent_id, $subItems, 0);
        $this->submenuTemplate = "\n{items}\n";
       // print_R($subItems); die;



        parent::init();
    }


    function searchChild($id, $subItems, $i)
    {
        $resArr = [];
        if ($i < $this->level) {
            foreach ($subItems as $item) {
                if ($item->parent_id == $id) {
                    $urlDec = Json::decode($item->url);
                   /* if ($item->id == 27) {
                        $urlDec['menu'] = "leadership/news";
                    }*/


                    $resArr[] = [
                        'label' => $item->translation->title,
                        'url' => $urlDec,
                       // 'sort' => $item->sort,
                        'items' => $this->searchChild($item->id, $subItems, $i+1),
                        'customClass' => ($i > 0) ? "page-menu__list-item--lvl" . ($i+1) : "",
                    ];
                }
            }
        }

        return $resArr;
    }

    protected function renderItems($items)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active']) {
                $class[] = $this->activeCssClass;
            }
            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }

            if (isset($item['customClass'])) {
                $class[] = $item['customClass'];
            }

            if (!empty($class)) {
                if (empty($options['class'])) {
                    $options['class'] = implode(' ', $class);
                } else {
                    $options['class'] .= ' ' . implode(' ', $class);
                }
            }

            $menu = $this->renderItem($item);
            if (!empty($item['items'])) {
                $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                $menu .= strtr($submenuTemplate, [
                    '{items}' => $this->renderItems($item['items']),
                ]);

               // print_r($menu); exit;
            }
            if ($tag === false) {
                $lines[] = $menu;
            } else {
                $lines[] = Html::tag($tag, $menu, $options);
            }
        }

        return implode("\n", $lines);
    }

    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0]) && $this->params != null) {
                unset($item['url']['#']);
                if (count($item['url']) > 1) {
               //определяем, какое значение стоит на третьем месте в ссылке - на месте идентификатора меню

                    $menuItem = explode("/", \Yii::$app->request->url);
                    if (isset($menuItem[2])) {

                        if ($item['url']['alias'] == $menuItem[2] && !isset($item['url']['menu'])) {
                            return true;
                        }
                    }

                    $params = $item['url'];
                    unset($params[0]);
                    foreach ($params as $name => $value) {
                        if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                            return false;
                        }
                    }
                }


            return true;
        }

        return false;
    }
}