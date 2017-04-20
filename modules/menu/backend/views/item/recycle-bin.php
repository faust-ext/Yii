<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\menu\backend\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пункты меню';
$this->subTitle = 'Корзина';

$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->subTitle;

$this->params['menu'][] = ['label' => '<i class="fa fa-fw fa-bars"></i> Список', 'url' => ['index'], 'options' => ['class' => 'btn btn-success']];


echo Html::beginTag('div', ['class' => 'item-recycle-bin']);



    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'created_at:datetime',
            'updated_at:datetime',
            'status',
            'menu_id',
            // 'sort',
            // 'parent_id',
            // 'url:ntext',
            [
                  'attribute' => 'title',
                  'value'     => 'translation.title',
            ],
            [
            'class'    => 'app\modules\core\backend\components\ActionColumn',
            'template' => '{restore} {erase}',
            ],
        ],
    ]);

echo Html::endTag('div');
