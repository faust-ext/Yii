<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\user\common\models\User */

$this->title = 'Пользователи';
$this->subTitle = 'Редактирование: ' . $model->username;

$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->subTitle;

$this->params['menu'][] = ['label' => '<i class="fa fa-fw fa-bars"></i> Список', 'url' => ['index'], 'options' => ['class' => 'btn btn-success']];

?>
<div class="user-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
