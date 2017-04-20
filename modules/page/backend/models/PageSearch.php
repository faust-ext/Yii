<?php

namespace app\modules\page\backend\models;

use app\modules\page\common\models\PageLang;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\page\common\models\Page;

/**
 * PageSearch represents the model behind the search form about `app\modules\page\common\models\Page`.
 */
class PageSearch extends Page
{
    public $title;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id',  'status'], 'integer'],
            [['alias', 'title'], 'safe'],
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
        $query = Page::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => ['defaultOrder' => ['updated_at' => SORT_DESC]],
        ]);

        $query->innerJoinWith(['translation']);

        $dataProvider->sort->attributes['title'] = [
            'asc'  => [PageLang::tableName() . '.title' => SORT_ASC],
            'desc' => [PageLang::tableName() . '.title' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'status' => $this->status,
            "from_unixtime(created_at, '%d.%m.%Y')" => $this->created_at,
            "from_unixtime(updated_at, '%d.%m.%Y')" => $this->updated_at,
        ]);

        $query->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['like', PageLang::tableName() . '.title', $this->title]);

        return $dataProvider;
    }
}
