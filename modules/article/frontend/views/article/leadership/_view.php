<?php
/* @var $model Article */
?>

<div class="text-block text-block--img">
    <a href="<?= $model->getFullImage('preview_image'); ?>" class="fancybox" title="<?=$model->translation->title?>">
        <img src="<?= $model->getThumbImage('preview_image', 100, 100); ?>" alt="">
    </a>

    <div class="text-block__content">
        <h4 class="name">
            <?= $model->translation->title; ?>
        </h4>

        <p class="post">
            <?= $model->translation->intro_text; ?>
        </p>

        <p>
            <?= $model->translation->full_text; ?>
        </p>
    </div>
</div>
