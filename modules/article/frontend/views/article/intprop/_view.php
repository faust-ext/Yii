<?php
/* @var $model Article */
?>
<? switch ($parent_id) {
    case 8:
        $parent_menu = 'patents';
        break;
    case 9:
        $parent_menu = 'intprop';

} ?>
<div class="text-block text-block--img">
    <img src="<? if ($model->preview_image != null) echo $model->getThumbImage('preview_image', 100, 100); ?>" alt="">

    <div class="text-block__content">
        <a href="<?= \yii\helpers\Url::to(['/article/article/view', 'id' => $model->id, 'menu' => $parent_menu]) ?>"
           class="blue-link">
            <?= $model->translation->title; ?>
        </a>

        <?= $model->translation->intro_text; ?>

    </div>
</div>




