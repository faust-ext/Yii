<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\modules\article\common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);

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

    echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary']);

    echo Html::endTag('div');

    ActiveForm::end();

    ?>

</div>
