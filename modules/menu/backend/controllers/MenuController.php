<?php

namespace app\modules\menu\backend\controllers;

use Yii;
use app\modules\menu\common\models\Menu;
use app\modules\menu\backend\models\MenuSearch;
use app\modules\core\backend\components\ARController;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends ARController
{
    protected function getModelClass()
    {
        return Menu::className();
    }

    protected function getSearchModelClass()
    {
        return MenuSearch::className();
    }
}
