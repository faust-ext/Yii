<?php

use yii\grid\GridView;

/* @var $this app\modules\core\backend\components\View */
/* @var $searchModel app\modules\user\backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->subTitle = 'Список';
$this->params['breadcrumbs'][] = $this->title;

$this->params['menu'][] = ['label' => '<i class="fa fa-fw fa-plus-square-o"></i>Добавить', 'url' => ['create'], 'options' => ['class' => 'btn btn-success']];
$this->params['menu'][] = ['label' => '<i class="fa fa-fw fa-trash-o"></i> Корзина', 'url' => ['recycle-bin'], 'options' => ['class' => 'btn btn-warning']];

?>
<div class="user-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'email:email',
            'username',
            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}{delete}'],
        ],
    ]); ?>

</div>
