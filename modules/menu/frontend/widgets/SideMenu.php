<?php

namespace app\modules\menu\frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

class SideMenu extends \yii\widgets\Menu {
    public $menu_id;

    public function init()
    {
        /* @var $menu \app\modules\menu\common\models\Menu */
        $menu = \app\modules\menu\common\models\Menu::find()->where(['id' => $this->menu_id])->active()->one();
        foreach($menu->items as $item) {
            $this->items[] = ['label' => $item->translation->title, 'url' => Json::decode($item->url)];
        }
        parent::init();
    }
}