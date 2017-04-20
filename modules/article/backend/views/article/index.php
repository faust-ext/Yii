<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\article\backend\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статьи';
$this->subTitle = 'Список';
$this->params['breadcrumbs'][] = $this->title;

$this->params['menu'][] = ['label' => '<i class="fa fa-fw fa-plus-square-o"></i>Добавить', 'url' => ['create'], 'options' => ['class' => 'btn btn-success']];
$this->params['menu'][] = ['label' => '<i class="fa fa-fw fa-trash-o"></i> Корзина', 'url' => ['recycle-bin'], 'options' => ['class' => 'btn btn-warning']];
?>
<div class="article-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'preview_image',
                'value'     => function ($data) {
                    return $data->preview_image ? $data->getThumbImage('preview_image', 100, 100) : false;
                },
                'format'    => 'image',
                'filter'    => false,
                'header'    => '',
            ],
            'id',
            [
                'attribute' => 'title',
                'value'     => 'translation.title'
            ],
            [
                'attribute' => 'categoryTitle',
                'value'     => 'category.translation.title'
            ],
            [
                'attribute' => 'authorName',
                'value'     => 'author.username'
            ],

            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}{delete}'],
        ],
    ]); ?>

</div>
