<div class="text-block text-block--img">
    <img src="/assets/images/img1.jpg" alt="">
    <div class="text-block__content">
        <a href="<?= \yii\helpers\Url::to(['/article/article/view', 'id' => $model->id]) ?>" class="blue-link">
            <?=$article->translation->title; ?>
        </a>
        <p>
            <?=$article->translation->intro_text; ?>
        </p>
    </div>
</div>