<?php

namespace app\modules\menu\backend\controllers;

use app\modules\menu\common\models\ItemLang;
use app\modules\menu\common\models\Menu;
use Yii;
use app\modules\menu\common\models\Item;
use app\modules\menu\backend\models\ItemSearch;
use app\modules\core\backend\components\ARController;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;


/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends ARController
{
    protected function getModelClass()
    {
        return Item::className();
    }

    protected function getSearchModelClass()
    {
        return ItemSearch::className();
    }

    public function actionGetList($id = null, $search = null, $menu_id = null)
    {
        $out = ['more' => false];

        $query = Item::find()
            ->joinWith(['translation'])
            ->active()
            ->select(['id', 'title']);

        if (!empty($menu_id)) {
            $query->andWhere([Item::tableName() . '.menu_id' => $menu_id]);
        }

        if (!empty($id) && (int)$id > 0) {
            $query->andWhere(['!=', Item::tableName() . '.id', $id]);
        }

        if (!empty($search)) {
            $query->andFilterWhere(['like', ItemLang::tableName() . '.title', $search]);
        }

        $items = $query->all();
        $out['results'] = [];

        foreach ($items as $item) {
            $out['results'][] = ['id' => $item->id, 'text' => $item->translation->title];
        }

        Yii::$app->response->format = 'json';

        return $out;
    }

    public function actionGetController($module_id = null, $controller_id = null)
    {
        $out = ['more' => false];
        $flag = false;

        $models = Menu::getModuleControllers();

        if ($module_id != null && !empty($models[$module_id]['controllers'])) {
            if ($controller_id) {
                $out['results'] = [
                    'id' => $controller_id,
                    'text' => $models[$module_id]['controllers'][$controller_id]['title']
                ];
            } else {
                foreach ($models[$module_id]['controllers'] as $key => $controller) {

                    $out['results'][] = ['id' => $key, 'text' => $controller['title']];
                    $flag = true;
                }

                if (!$flag) {
                    $out['results'][] = ['id' => ' ', 'text' => 'Ничего не найдено'];
                }
            }
        } else {
            $out['results'][] = ['id' => ' ', 'text' => 'Ничего не найдено'];
        }

        Yii::$app->response->format = 'json';

        return $out;

    }

    public function actionGetAction($module_id = null, $controller_id = null, $action_id = null)
    {
        $out = ['more' => false];
        $models = Menu::getModuleControllers();

        if ($module_id != null && $controller_id != null && !empty($models[$module_id]['controllers'][$controller_id]['actions'])) {

            if ($action_id) {
                $out['results'] = [
                    'id' => $action_id,
                    'text' => $models[$module_id]['controllers'][$controller_id]['actions'][$action_id]['title']
                ];
            } else {
                foreach ($models[$module_id]['controllers'][$controller_id]['actions'] as $key => $action) {
                    $out['results'][] = ['id' => $key, 'text' => $action['title']];
                }
            }
        } else {
            $out['results'][] = ['id' => ' ', 'text' => 'Ничего не найдено'];
        }


        Yii::$app->response->format = 'json';

        return $out;
    }

    public function actionGetParams($module_id = null, $controller_id = null, $action_id = null, $params = null)
    {
        $result = '';
        $items = Menu::getModuleControllers();



        if ($module_id != null && $controller_id != null && $action_id != null && !empty($items[$module_id]['controllers'][$controller_id]['actions'][$action_id]['params'])) {
                foreach ($items[$module_id]['controllers'][$controller_id]['actions'][$action_id]['params'] as $key => $param) {
                    $htmlOptions = ['empty' => '---Выберите ' . $param['title'] . '---', 'class' => 'form-control'];
                    $result .= Html::beginTag('div', ['class' => 'form-group']);
                    $result .= Html::label($param['title'], 'Item_' . 'params[' . $param['name'] . ']',
                        ['class' => 'control-label']);
                    $result .= Html::activeDropDownList(new Item(), 'params[' . $param['name'] . ']', $param['items'],
                        $htmlOptions);
                    $result .= Html::endTag('div');
            }
        }
        echo $result;
        Yii::$app->end();
    }

}
