<?php
namespace app\modules\core\frontend\widgets;

use app\modules\core\common\models\Lang;
use yii;
use yii\base\Widget;
use yii\helpers\Html;

class LangSwitcher extends Widget
{
    public function run()
    {
        $currentUrl = ltrim(Yii::$app->request->url, '/');
        $links = array();
        foreach (Lang::getList() as $i => $item){
            if($item->prefix != 'ru')
                $url = '/' . ($item->prefix ? trim($item->prefix, '_') . '/' : '') . $currentUrl;
            else
                $url = '/' . $currentUrl;

            if($item->id != Lang::getCurrent()->id) {
                $links[] = Html::a(strtoupper($item->prefix), $url, ['class' => 'language']);
            }
            else {
                $links[] = Html::a(strtoupper($item->prefix), $url,
                    ['class' => 'active language']);
            }

        }
        // parent::init();
        echo implode(" | ", $links);
    }
}