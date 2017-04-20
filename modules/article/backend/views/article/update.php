<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\article\common\models\Article */

$this->title = 'Статьи';
$this->subTitle = 'Редактирование: ' . $model->translation->title;

$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->subTitle;

$this->params['menu'][] = ['label' => '<i class="fa fa-fw fa-bars"></i> Список',
    'url' => ['index'], 'options' => ['class' => 'btn btn-success']];

?>
<div class="user-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
