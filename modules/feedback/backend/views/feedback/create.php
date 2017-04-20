<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\feedback\common\models\Feedback */

$this->title = 'Вопросы и ответы';
$this->subTitle = 'Добавить';

$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->subTitle;
?>

<div class="feedback-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
