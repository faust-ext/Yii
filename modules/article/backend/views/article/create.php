<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\article\common\models\Article */

$this->title = 'Статьи';
$this->subTitle = 'Добавить';

$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->subTitle;
?>

<div class="article-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
