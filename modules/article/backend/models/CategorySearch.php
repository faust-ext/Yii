<?php

namespace app\modules\article\backend\models;

use app\modules\article\common\models\CategoryLang;
use app\modules\core\backend\components\TreeActiveDataProvider;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\article\common\models\Category;

/**
 * CategorySearch represents the model behind the search form about `app\modules\article\common\models\Category`.
 */
class CategorySearch extends Category
{
    public $title;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id',  'status'], 'integer'],
            [['title'], 'safe'],
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
        $query = Category::find();


        $dataProvider = new TreeActiveDataProvider([
            'query' => $query,
            'sort'  => ['defaultOrder' => ['updated_at' => SORT_DESC]]
        ]);

        $query->innerJoinWith(['translation']);

        $dataProvider->sort->attributes['title'] = [
            'asc'  => [CategoryLang::tableName() . '.title' => SORT_ASC],
            'desc' => [CategoryLang::tableName() . '.title' => SORT_DESC],
        ];

        if(Yii::$app->controller->action->id == 'recycle-bin')
            $query->isEmpty = false;

        if (!($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if($this->id || $this->title) {
            $query->isEmpty = false;
        }

        $query->andFilterWhere([
            "from_unixtime(created_at, '%d.%m.%Y')" => $this->created_at,
            "from_unixtime(updated_at, '%d.%m.%Y')" => $this->updated_at,
        ]);

        $query
            ->andFilterWhere(['id' => 11]);
//            ->andFilterWhere(['like', CategoryLang::tableName() . '.title', $this->title]);

        return $dataProvider;
    }
}
