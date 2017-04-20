<?php
/* @var $model Article */
?>

<img src="<?= $model->getThumbImage('preview_image', 100, 100); ?>" alt="">
<div class="text-block__content">
    <? switch ($parent_id) {
        case 6:
            $parent_menu = 'leadership';
            break;
        case 8:
            $parent_menu = 'peptides';
            break;
        case 10:
            $parent_menu = 'cosmetics';
            break;
        case 11:
            $parent_menu = 'publics';
            break;
        default:
            break;
    } ?>
    <a href="<?= \yii\helpers\Url::to(['/article/article/view', 'id' => $model->id, 'menu' => $parent_menu]) ?>"
       class="blue-link">
        <?= $model->translation->title; ?>
    </a>
    <? $text = str_replace('%Артикул%', '', $model->translation->intro_text);
    echo $text;
   ?>
</div>




