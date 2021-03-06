<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\modules\core\backend\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '<?= $generator->moduleTitle; ?>';
$this->subTitle = 'Список';
$this->params['breadcrumbs'][] = $this->title;

$this->params['menu'][] = ['label'   => '<i class="fa fa-fw fa-plus-square-o"></i>Добавить',
                           'url'     => ['create'],
                           'options' => ['class' => 'btn btn-success']
];
$this->params['menu'][] = ['label'   => '<i class="fa fa-fw fa-trash-o"></i> Корзина',
                           'url'     => ['recycle-bin'],
                           'options' => ['class' => 'btn btn-warning']
];


echo Html::beginTag('div', ['class' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index']);

<?php if ($generator->indexWidgetType === 'grid'): ?>
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "            '" . $name . "',\n";
        } else {
            echo "            // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . (in_array($column->name, ['created_at', 'updated_at']) ? ":datetime" : "") . "',\n";
        } else {
            echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
    if($generator->isLang) {
        $colName = $generator->getLangNameAttribute();

        echo "            [\n";
        echo "                  'attribute' => '". $colName ."',\n";
        echo "                  'value'     => 'translation.". $colName ."',\n";
        echo "            ],\n";

    }
?>
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}{delete}'],
        ],
    ]);
<?php else: ?>
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ])
<?php endif; ?>

echo Html::endTag('div');
