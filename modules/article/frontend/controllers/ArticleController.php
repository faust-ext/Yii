<?php

namespace app\modules\article\frontend\controllers;

use app\modules\article\common\models\Article;
use app\modules\article\common\models\Category;
use app\modules\menu\common\models\Item;
use app\modules\menu\common\models\Menu;
use app\modules\page\common\models\Page;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\HttpException;
use yii\data\Pagination;

class ArticleController extends Controller
{

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

        return $item;
    }

    public function actionIndex($alias, $menu=null)
    {
        if ($menu == null)
            $menu = $alias;


        $category = $this->loadCategoryModel($alias, ['translation', 'articles', 'articles.translation']);
        $dataProvider = new ActiveDataProvider([
            'query' => $category->getArticles()->where(['status' => 1]),
            'pagination' => ['pageSize' => 12],

        ]);

        if ($category->parent_id != null) {
            $parent = Category::find()
                ->with(['translation'])
                ->where(['id' => $category->parent_id])
                ->one();
            $title = $parent->translation->title;
        }
        else
            $title = $category->translation->title;
       // echo $menu; die;
        //определяем, на какое меню надо отрисовать
        $menu = $this->whichMenu($menu);
        $parent_id = $menu->id;
        $menu_name = $menu->translation->title;
        $typeMenu = Menu::find()->where(['id' => $menu->menu_id])->one();


        return $this->render($category->pattern . '/index', [
            'category' => $category,
            'dataProvider' => $dataProvider,
            'category' => $category,
            'title' => $title,
            'parent_id' => $parent_id,
            'menu_name' => $menu_name,
            'type_menu' => $typeMenu->title,
            'patents_menu_id' => $menu->menu_id,
        ]);

    }

     public function actionView($id, $menu)
    {
        $model = Article::find()
            ->with(['translation', 'category', 'category.translation'])
            ->where(['id' => $id])
            ->one();

        $menu_w = $this->whichMenu($menu);

        if ($model->category_id == 2 || $model->category_id == 5) {
            return $this->render('detail', [
                'menu' => $menu,
                'model' => $model,
                //  'seeAlso' => $seeAlso,
            ]);
        } else {
            return $this->render('product_detail', [
                'model' => $model,
                'parent_id' => $menu,
                'menu_name' => $menu_w->translation->title,
                //  'seeAlso' => $seeAlso,
            ]);
        }
    }

    public function actionDetail($nid, $menu)
    {
        $model = Article::find()
            ->with(['translation', 'category', 'category.translation'])
            ->where(['id' => $nid])
            ->one();

        return $this->render('detail', [
            'model' => $model,
            'menu' => $menu,
            //  'seeAlso' => $seeAlso,
        ]);
    }

    public function actionCategoryList($alias, $menu=null)
    {

        if ($menu == null)
            $menu = $alias;

        $model = Category::find()
            ->with(['translation', 'articles', 'articles.translation'])
            ->where(['alias' => $alias])
            ->one();

        $category = $this->loadCategoryModel($alias, ['translation', 'articles', 'articles.translation']);

        $menu = $this->whichMenu($menu);
        $parent_id = $menu->id;
        $menu_name = $menu->translation->title;

        if ($model === null) {
            throw new HttpException(404);
        }



        return $this->render('peptides', [
            'model' => $model,
            'parent_id' => $parent_id,
            'category' => $category
        ]);
    }

    public function actionCitogen($alias, $menu)
    {
        $pages = Page::find()
            ->with(['translation'])
            ->where(['status' => 1])
            ->andWhere(['alias' => $alias])
            ->all();

        $menu = $this->whichMenu($menu);
        $parent_id = $menu->id;
        $menu_name = $menu->translation->title;

        $dataProvider = new ActiveDataProvider([
            'query' => $pages,
            'pagination' => ['pageSize' => 1],
        ]);

        return $this->render('peptides_citogenu/index', [
            'dataProvider' => $dataProvider,
            'parent_id' => $parent_id,

        ]);
    }

    /**
     * @param $alias
     * @param $with
     * @return Category
     * @throws HttpException
     */
    public function loadCategoryModel($alias, $with) {
        $model = Category::find()
            ->with($with)
            ->where(['alias' => $alias])
            ->one();

        if($model !== null)
            return $model;
        else
            throw new HttpException(404);
    }
}