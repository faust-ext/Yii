<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\menu\common\models\Item */

$this->title = 'Пункты меню';
$this->subTitle = 'Редактирование: ' . $model->translation->title;

$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->subTitle;

$model->parseUrl();

$this->params['menu'][] = ['label' => '<i class="fa fa-fw fa-bars"></i> Список', 'url' => ['index'], 'options' => ['class' => 'btn btn-success']];
?>
<div class="item-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
