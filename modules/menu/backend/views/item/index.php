<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\menu\backend\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пункты меню';
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


echo Html::beginTag('div', ['class' => 'item-index']);

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'title',
                'value'     => function ($data) {
                    return str_repeat('&nbsp;', $data->indent * 4) . $data->translation->title;
                },
                'format'    => 'raw'
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'menu',
                'value'     => 'menu.title',
            ],
            'sort',
            // 'parent_id',
            // 'url:ntext',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}{delete}'],
        ],
    ]);

echo Html::endTag('div');
