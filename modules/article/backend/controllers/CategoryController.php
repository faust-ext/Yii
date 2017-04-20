<?php

namespace app\modules\article\backend\controllers;

use Yii;
use app\modules\article\common\models\Category;
use app\modules\article\backend\models\CategorySearch;
use app\modules\core\backend\components\ARController;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends ARController
{
    protected function getModelClass()
    {
        return Category::className();
    }

    protected function getSearchModelClass()
    {
        return CategorySearch::className();
    }
}
