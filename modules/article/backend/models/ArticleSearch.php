<?php

namespace app\modules\article\backend\models;

use app\modules\article\common\models\ArticleLang;
use app\modules\article\common\models\CategoryLang;
use app\modules\user\common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\article\common\models\Article;

/**
 * ArticleSearch represents the model behind the search form about `app\modules\article\common\models\Article`.
 */
class ArticleSearch extends Article
{
    public $title;
    public $categoryTitle;
    public $authorName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'category_id', 'author_id', 'published_at', 'published_until'], 'integer'],
            [['title', 'categoryTitle', 'authorName'], 'safe'],
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
        $query = Article::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => ['defaultOrder' => ['updated_at' => SORT_DESC]]
        ]);

        $query->innerJoinWith(['translation', 'author', 'category', 'category.translation']);

        $dataProvider->sort->attributes['title'] = [
            'asc'  => [ArticleLang::tableName() . '.title' => SORT_ASC],
            'desc' => [ArticleLang::tableName() . '.title' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['categoryTitle'] = [
            'asc'  => [CategoryLang::tableName() . '.title' => SORT_ASC],
            'desc' => [CategoryLang::tableName() . '.title' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['authorName'] = [
            'asc'  => [User::tableName() . '.username' => SORT_ASC],
            'desc' => [User::tableName() . '.username' => SORT_DESC],
        ];

        ;

        if (!($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'articles.id' => $this->id,
            "from_unixtime(articles.created_at, '%d.%m.%Y')" => $this->created_at,
            "from_unixtime(articles.updated_at, '%d.%m.%Y')" => $this->updated_at,
            'status' => $this->status,
            'category_id' => $this->category_id,
            'author_id' => $this->author_id,
            'published_at' => $this->published_at,
            'published_until' => $this->published_until,
        ]);

        $query
            ->andFilterWhere(['like', ArticleLang::tableName() . '.title', $this->title])
            ->andFilterWhere(['like', User::tableName() . '.username', $this->authorName])
            ->andFilterWhere(['like', CategoryLang::tableName() . '.title', $this->categoryTitle]);

        return $dataProvider;
    }
}
