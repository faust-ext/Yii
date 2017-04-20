<?php
/**
 * This is the template for generating CRUD search class of the specified model.
 */

use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator app\modules\core\backend\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);
$langModelClass = StringHelper::basename($generator->langModelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $modelAlias = $modelClass . 'Model';
}
$rules = $generator->generateSearchRules();
$labels = $generator->generateSearchLabels();
$searchAttributes = $generator->getSearchAttributes();
$searchConditions = $generator->generateSearchConditions();
$langAttribute = $generator->getLangNameAttribute();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->searchModelClass, '\\')) ?>;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use <?= ltrim($generator->modelClass, '\\') . (isset($modelAlias) ? " as $modelAlias" : "") ?>;
use <?= ltrim($generator->langModelClass, '\\');?>;

/**
 * <?= $searchModelClass ?> represents the model behind the search form about `<?= $generator->modelClass ?>`.
 */
class <?= $searchModelClass ?> extends <?= isset($modelAlias) ? $modelAlias : $modelClass ?>

{
    public $<?= $langAttribute ;?>;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            <?= implode(",\n            ", $rules) ?>,
            [['<?= $langAttribute ;?>'], 'safe'],
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
        $query = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => ['defaultOrder' => ['updated_at' => SORT_DESC]]
        ]);

        <?php if($generator->isLang) { ?>

        $query->innerJoinWith(['translation']);

        $dataProvider->sort->attributes['<?=$langAttribute;?>'] = [
            'asc'  => [<?=$langModelClass;?>::tableName() . '.<?=$langAttribute;?>' => SORT_ASC],
            'desc' => [<?=$langModelClass;?>::tableName() . '.<?=$langAttribute;?>' => SORT_DESC],
        ];
        <?php } ?>

        if (!($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        <?= implode("\n        ", $searchConditions) ?>

        <?php if($generator->isLang) { ?>

        $query->andFilterWhere(['like', <?=$langModelClass;?>::tableName() . '.<?=$langAttribute;?>', $this-><?=$langAttribute;?>]);

        <?php } ?>

        return $dataProvider;
    }
}
