<?php
namespace app\modules\core\backend\components;

use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\QueryInterface;
use yii\helpers\ArrayHelper;
use app\modules\core\common\models\Status;
use app\modules\menu\common\models\Item;
use app\modules\menu\common\models\ItemQuery;

class TreeActiveDataProvider extends ActiveDataProvider
{
    public $childRelation = 'children';
    public $levelColumn = 'level';
    public $isActive = Status::ACTIVE;
    public $flag = false;

    protected function prepareTotalCount()
    {
        if (!$this->query instanceof QueryInterface) {
            throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
        }

        $query = clone $this->query;
        if ($this->query->modelClass == 'app\modules\menu\common\models\Item')
            return (int) $query->andWhere(['menu_items.status' => $this->isActive])->count();
        else
            return (int) $query->andWhere(['articles_categories.status' => $this->isActive])->count();
    }

    public function cmp($a, $b)
    {
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }

    /**
     * @inheritdoc
     */
    protected function prepareModels()
    {
        if (!$this->query instanceof QueryInterface) {
            throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
        }

        $totalCount = 0;
        if ($this->query->modelClass == 'app\modules\menu\common\models\Item') {
            $this->query->andWhere(['menu_items.status' => $this->isActive]);

            $totalCount = $this->query->count();
        } else {
            $this->query->andWhere(['articles_categories.status' => $this->isActive]);
            $totalCount = $this->query->count();
        }

        if (($pagination = $this->getPagination()) !== false) {
            $pagination->totalCount = $totalCount;
            $this->query->limit($pagination->getLimit())->offset($pagination->getOffset());
        }

        $items = $this->query->all();
        $itemsArrSorted = $items;

        uasort($itemsArrSorted, function ($a, $b) {
            if ($a['parent_id'] == $b['parent_id']) {
                return 0;
            }

            return ($a['parent_id'] < $b['parent_id']) ? -1 : 1;
        });

        if ($this->query->isEmpty) {
            foreach ($itemsArrSorted as &$val) {
                if ((int)$val->status != (int)$this->isActive) {
                    continue;
                }

                $val->indent = 0;

                if ($val->parent_id) {
                    $parindent = 0;
                    foreach ($items as $currItem) {
                        if ($currItem->id == $val->parent_id) {
                            $parindent = $currItem->indent;
                            break;
                        }
                    }
                    $val->indent = ++$parindent;
                }
            }

            foreach ($items as &$val) {
                foreach ($itemsArrSorted as $key => $valItemSorted) {
                    if ($valItemSorted->id == $val->id) {
                        $val->indent = $valItemSorted->indent;
                        unset($itemsArrSorted[$key]);
                        break;
                    }
                }
            }
        }

        return $items;
    }

}