<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\ckeditor\CKEditor;

use app\modules\user\common\models\User;

/* @var $this yii\web\View */
/* @var $model app\modules\feedback\common\models\Feedback */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="feedback-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lang_id')->dropDownList(\app\modules\core\common\models\Lang::getDropdown()) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'answerer_id')->widget(Select2::classname(), [
        'data'          => User::getDropdown(),
        'options'       => ['placeholder' => 'Выберите ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'question')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, "answer")->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
