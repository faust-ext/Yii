<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\modules\user\common\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'fieldConfig' => [
            'template' => "{input}",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <div class="form-group has-feedback">
        <?= $form->field($model, 'username') ?>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
    </div>

    <div class="form-group has-feedback">
    <?= $form->field($model, 'password')->passwordInput() ?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>


    <div class="row">
        <div class="col-xs-8">
            <div class="checkbox icheck">
                <?=$form->field($model, 'rememberMe')->checkbox([
                    'template' => "{input}&nbsp;&nbsp;" . $model->getAttributeLabel('rememberMe')
                ]);?>
            </div>
        </div><!-- /.col -->
        <div class="col-xs-4">
            <?= Html::submitButton('Войти', ['class' => 'btn btn-warning btn-block btn-flat', 'name' => 'login-button']) ?>
        </div><!-- /.col -->
    </div>

    <?php ActiveForm::end(); ?>
</div>
