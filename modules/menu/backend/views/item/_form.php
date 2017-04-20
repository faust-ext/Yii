<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\modules\menu\common\models\Item */
/* @var $form yii\widgets\ActiveForm */

echo Html::beginTag('div', ['class' => 'item-form']);
$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
$items = [
    [
        'label'   => 'Данные',
        'content' => $this->render('_form_common', ['form' => $form, 'model' => $model]),
        'active'  => true
    ]
];
foreach ($model->getTranslations() as $translation) {
    $items[] = [
        'label'   => $translation->lang->title,
        'content' => $this->render('_form_lang', ['form' => $form, 'model' => $translation]),
    ];
}
echo Tabs::widget(['items' => $items]);
echo Html::beginTag('div', ['class' => 'form-group']);
echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary']);
echo Html::endTag('div');
ActiveForm::end();
echo Html::endTag('div');