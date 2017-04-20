<?php

namespace app\modules\menu\backend\models;

use app\modules\core\backend\components\TreeActiveDataProvider;
use app\modules\menu\common\models\Menu;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\menu\common\models\Item;
use app\modules\menu\common\models\ItemLang;

/**
 * ItemSearch represents the model behind the search form about `app\modules\menu\common\models\Item`.
 */
class ItemSearch extends Item
{
    public $title;
    public $menu;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'menu_id', 'sort', 'parent_id'], 'integer'],
            [['url'], 'safe'],
            [['title', 'menu'], 'safe'],
            [['created_at', 'updated_at'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Item::find();

        $dataProvider = new TreeActiveDataProvider([
            'query' => $query,
            'sort'  => ['defaultOrder' => ['updated_at' => SORT_DESC]]
        ]);

        $query->innerJoinWith(['translation', 'menu']);

        $dataProvider->sort->attributes['title'] = [
            'asc'  => [ItemLang::tableName() . '.title' => SORT_ASC],
            'desc' => [ItemLang::tableName() . '.title' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['menu'] = [
            'asc'  => [Menu::tableName() . '.title' => SORT_ASC],
            'desc' => [Menu::tableName() . '.title' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if($this->id || $this->title) {
            $query->isEmpty = false;
        }

        $query->andFilterWhere([
            Item::tableName() . '.id'         => $this->id,
            "from_unixtime(" . Item::tableName() .".created_at, '%d.%m.%Y')" => $this->created_at,
            "from_unixtime(" . Item::tableName() . ".updated_at, '%d.%m.%Y')" => $this->updated_at,
            'status'     => $this->status,
            'menu_id'    => $this->menu_id,
            'sort'       => $this->sort,
            'parent_id'  => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url]);

        $query->andFilterWhere(['like', ItemLang::tableName() . '.title', $this->title]);
        $query->andFilterWhere(['like', Menu::tableName() . '.title', $this->menu]);

        return $dataProvider;
    }
}
