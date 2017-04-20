<?php
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;
use kartik\widgets\FileInput;
use app\modules\article\common\models\Category;

?>

<p>

    <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
        'data'          => $model->isNewRecord ? Category::getDropdown() : Category::getDropdown([$model->id]),
        'options'       => ['placeholder' => 'Выберите ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => 30]) ?>


    <?= $form->field($model, 'pattern')->dropDownList([
        'leadership' => 'Руководство',
        'news' => 'Новости',
        'cosmetics' => 'Кометическая линия',
        'peptides' => 'Пептидные биорегуляторы',
        'peptides_citogenu' => 'Цитогены',
        'intprop' => 'Интеллектуальная собственность',
        'public' => 'Публикации'
    ]) ?>

    <?php
    $initialPreview = [];
    if($model->image) {
        $initialPreview[] = \yii\helpers\Html::img($model->getFullImage('image'), ['class'=>'file-preview-image']);
    }

    echo  $form->field($model, 'image')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'initialPreview'=> !empty($initialPreview) ? $initialPreview : false,
            'showUpload' => false
        ],
        'pluginEvents' => [
            "fileclear" => "function() { $('#article-is_deleted-image').val(1); }",
        ]
    ]);

    echo \yii\helpers\Html::activeHiddenInput($model, 'is_deleted[image]');

    ?>

</p>