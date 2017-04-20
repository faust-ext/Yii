<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\menu\common\models\ItemLang */
/* @var $form yii\widgets\ActiveForm */

echo Html::beginTag('p');

echo $form->field($model, "[{$model->lang_id}]title");


echo Html::endTag('p');