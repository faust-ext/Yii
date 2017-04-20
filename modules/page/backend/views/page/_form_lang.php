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

    <?= $form->field($model, "[{$model->lang_id}]text")->widget(CKEditor::className(), [
        'options' => ['rows' => 6 ],
        'preset' => 'full',
        'clientOptions' => [
            'allowedContent' => true,
            'extraAllowedContent' => 'section',
            'disableAutoInline' => false,
            'filebrowserUploadUrl' => Url::to(['/core/site/upload']),
        ],
    ]) ?>

</p>-
