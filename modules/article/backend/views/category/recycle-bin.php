<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\article\backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории статей';
$this->subTitle = 'Корзина';

$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->subTitle;

$this->params['menu'][] = ['label' => '<i class="fa fa-fw fa-bars"></i> Список', 'url' => ['index'], 'options' => ['class' => 'btn btn-success']];
?>
<div class="category-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'title',
                'value'     => 'translation.title'
            ],
            'status',
            'parent_id',
            'created_at:datetime',
            'updated_at:datetime',


            [
                'class'    => 'app\modules\core\backend\components\ActionColumn',
                'template' => '{restore} {erase}',
            ],
        ],
    ]); ?>

</div>
