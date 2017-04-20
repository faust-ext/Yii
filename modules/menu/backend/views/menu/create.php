<?php

/* @var $this yii\web\View */
/* @var $model app\modules\menu\common\models\Menu */

$this->title = 'Меню';
$this->subTitle = 'Добавить';

$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->subTitle;

$this->params['menu'][] = ['label' => '<i class="fa fa-fw fa-bars"></i> Список', 'url' => ['index'], 'options' => ['class' => 'btn btn-success']];
?>
<div class="menu-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
