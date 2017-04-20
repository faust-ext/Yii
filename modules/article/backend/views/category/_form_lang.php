<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

<p>

    <?= $form->field($model, "[{$model->lang_id}]title")->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, "[{$model->lang_id}]description")->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>

</p>