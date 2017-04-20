<?php

namespace app\modules\page\backend\controllers;

use app\modules\page\backend\models\PageSearch;
use app\modules\page\common\models\Page;
use app\modules\core\backend\components\ARController;
use Yii;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends ARController
{
    protected function getModelClass()
    {
        return Page::className();
    }

    protected function getSearchModelClass()
    {
        return PageSearch::className();
    }
}