<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\feedback\common\models\Feedback */

$this->title = 'Вопросы и ответы';
$this->subTitle = 'Редактирование: #' . $model->id;

$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->subTitle;

$this->params['menu'][] = ['label' => '<i class="fa fa-fw fa-bars"></i> Список', 'url' => ['index'], 'options' => ['class' => 'btn btn-success']];

?>
<div class="feedback-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
