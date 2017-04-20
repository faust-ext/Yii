<?php

namespace app\modules\article\frontend\widgets;

use app\modules\article\common\models\Article;
use yii\base\Widget;

class SeeAlsoWidget extends Widget
{
    public $categoryId;
    public $exclude;
    public $menu;

    public function run()
    {
        $models = Article::find()
            ->with(['translation'])
            ->where(['category_id' => $this->categoryId])
            ->andWhere(['NOT IN', 'id', $this->exclude])
            ->andWhere(['status' => 1])
            ->orderBy(['rand()' => SORT_DESC])
            ->limit(2)
            ->all();

        if($models !== null) {
            return $this->render('seeAlso', ['models' => $models, 'parent_menu' => $this->menu]);
        }
    }
}