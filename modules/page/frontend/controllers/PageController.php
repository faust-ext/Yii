<?php

namespace app\modules\page\frontend\controllers;


use app\modules\article\common\models\Article;
use app\modules\menu\common\models\Item;
use app\modules\page\common\models\Page;
use yii\web\Controller;


class PageController extends Controller
{
   /* public function actionIndex($alias)
    {
         return $this->render($alias);
    }*/
    public function whichMenu($menu)
    {
        $menuName = explode('/', $menu);
        $menus = Item::find()->with(['translation'])->where(['status' => 1])->andWhere(['parent_id' => null])->all();
        foreach ($menus as $item)
        {
            $m = explode(":", $item->url);

            $menuAlias = str_replace(["'", '"', '}', ',', 'menu'], '', $m[2]);
            /* var_dump("mn ". $menuName[0]);
             echo '====';
             var_dump( "ma " . $menuAlias);
             echo "\n";*/
            if ($menuAlias == $menuName[0]) {
                $parent_id = $item->id;
                break;
            }
        }
        /* switch($menu)
         {
             case 'leadership':
                 $parent_id = 6;
                 break;
             case 'peptides':
                 $parent_id = 8;
                 break;
             case 'cosmetics':
                 $parent_id = 10;
                 break;
             case 'publics':
                 $parent_id = 11;
                 break;

             default:
                 $parent_id = 0;
                 break;
         }*/
        // echo $parent_id; die;
        return $item;
    }

    public function actionIndex($alias, $menu = null)
    {
        if ($menu == null)
            $menu = $alias;

        $model = Page::find()
            ->with(['translation'])
            ->where(['alias' => $alias])
            ->one();

        $menu = $this->whichMenu($menu);
        $parent_id = $menu->id;

        return $this->render('index', [
            'model' => $model,
            'parent_id' => $parent_id,
        ]);
    }


    public function actionView($id)
    {
        $model = Page::find()
            ->with(['translation'])
            ->where(['id' => $id])
            ->one();

        var_dump($model); die;

        return $this->render('product',[
            'model' => $model,
        ]);
    }
}
