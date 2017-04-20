<?php
/* @var $model Article */
?>
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
        }
        ?>

        <a href="<?= \yii\helpers\Url::to(['/article/article/detail', 'nid' => $model->id, 'menu' => $parent_menu]) ?>" class="blue-link">
            <?=$model->translation->title; ?>
        </a>
        <?=$model->translation->intro_text; ?>
        <p class="date">
            <?php if ($model->published_at != null) echo date('d.m.y', $model->published_at );?>
        </p>
    </div>
