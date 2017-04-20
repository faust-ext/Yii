<?php

namespace app\modules\feedback\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\feedback\common\models\Feedback;

/**
 * FeedbackSearch represents the model behind the search form about `app\modules\feedback\common\models\Feedback`.
 */
class FeedbackSearch extends Feedback
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'answered_at', 'status', 'lang_id', 'answerer_id'], 'integer'],
            [['name', 'email', 'question', 'answer'], 'safe'],
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
        $query = Feedback::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'answered_at' => $this->answered_at,
            'status' => $this->status,
            'lang_id' => $this->lang_id,
            'answerer_id' => $this->answerer_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'question', $this->question])
            ->andFilterWhere(['like', 'answer', $this->answer]);

        return $dataProvider;
    }
}
