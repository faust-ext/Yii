<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\article\backend\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Обратная связь';
$this->subTitle = 'Корзина';

$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->subTitle;

$this->params['menu'][] = ['label' => '<i class="fa fa-fw fa-bars"></i> Список', 'url' => ['index'], 'options' => ['class' => 'btn btn-success']];
?>
<div class="feedback-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'status',
            'created_at:datetime',
            'updated_at:datetime',
            'name',
            'question:ntext',
            'answer:ntext',

            [
                'class'    => 'app\modules\core\backend\components\ActionColumn',
                'template' => '{restore} {erase}',
            ],
        ],
    ]); ?>

</div>
