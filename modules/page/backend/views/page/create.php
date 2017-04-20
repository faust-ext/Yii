<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\page\common\models\Page */

$this->title = 'Страницы';
$this->subTitle = 'Добавить';

$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->subTitle;
?>
<div class="page-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
