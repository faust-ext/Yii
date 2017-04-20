<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\modules\core\backend\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->langModelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

$skipAttributes =  array_keys($model->getPrimaryKey());

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->langModelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */

echo Html::beginTag('p');

<?php foreach ($generator->getLangColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes) && !in_array($attribute, $skipAttributes)) {
        echo "echo " . $generator->generateLangActiveField($attribute) . ";\n\n";
    }
} ?>

echo Html::endTag('p');