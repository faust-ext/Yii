<?php
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;
use kartik\widgets\FileInput;

use app\modules\article\common\models\Category;
use app\modules\user\common\models\User;

$model->published_at = $model->published_at ? date('d.m.Y H:i:s', $model->published_at) : null;
$model->published_until = $model->published_until ? date('d.m.Y H:i:s', $model->published_until) : null;

?>

<p>

    <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
        'data'          => Category::getDropdown(),
        'options'       => ['placeholder' => 'Выберите ...'],
        'pluginOptions' => [
            'allowClear' => true

        ],
    ]); ?>

    <?= $form->field($model, 'author_id')->widget(Select2::classname(), [
        'data'          => User::getDropdown(),
        'options'       => ['placeholder' => 'Выберите ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'published_at')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Выберите ...'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy hh:ii:ss'
        ]
    ]); ?>

    <?= $form->field($model, 'published_until')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Выберите ...'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy hh:ii:ss'
        ]
    ]); ?>

    <?php
    $initialPreview = [];
    if($model->preview_image) {
        $initialPreview[] = \yii\helpers\Html::img($model->getFullImage('preview_image'), ['class'=>'file-preview-image']);
    }

    echo  $form->field($model, 'preview_image')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'initialPreview'=> !empty($initialPreview) ? $initialPreview : false,
            'showUpload' => false
        ],
        'pluginEvents' => [
            "fileclear" => "function() { $('#article-is_deleted-preview_image').val(1); }",
        ]
    ]);

    echo \yii\helpers\Html::activeHiddenInput($model, 'is_deleted[preview_image]');

    ?>

</p>