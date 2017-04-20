<?php
/**
 * @var $models app\modules\article\common\models\Article[]
 */
?>

<div class="see-also">
    <div class="row">
        <?foreach ($models as $model) {?>
            <div class="text-block text-block--img col col-6">
                <img src="<?if ($model->preview_image != null) echo $model->getThumbImage('preview_image', 100, 100);?>" alt="">
                <div class="text-block__content">
                    <a href="<?= \yii\helpers\Url::to(['/article/article/view', 'id' => $model->id, 'menu' => $parent_menu]) ?>" class="blue-link">
                        <?=$model->translation->title?>
                    </a>

                    <?=$model->translation->intro_text?>

                    <p class="date">
                        <?php if ($model->published_at != null) echo date('d.m.y', $model->published_at );?>
                    </p>
                </div>
            </div>
        <?}?>

    </div>
</div>