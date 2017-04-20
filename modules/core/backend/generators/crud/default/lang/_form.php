<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\modules\core\backend\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model          = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */

echo Html::beginTag('div', ['class' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form']);
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