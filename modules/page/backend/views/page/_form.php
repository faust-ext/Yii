<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\modules\page\common\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin();

    $items = [
    [
    'label'   => 'Данные',
    'content' => $this->render('_form_common', ['form' => $form, 'model' => $model]),
    'active'  => true
    ]
    ];

    foreach($model->getTranslations() as $translation) {
    $items[] = [
    'label' => $translation->lang->title,
    'content' => $this->render('_form_lang', ['form' => $form, 'model' => $translation]),
    ];
    }

    echo Tabs::widget([
    'items' => $items
    ]);

    echo Html::beginTag('div', ['class' => 'form-group']);

    echo Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить',
    ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);

    echo Html::endTag('div');

    ActiveForm::end(); ?>

</div>
