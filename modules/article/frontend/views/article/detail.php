<div class="news-details-page page">
    <div class="wrap">
        <div class="row">
            <section class="page-content">
                <div class="page-title">
                    <h1>
                        Научные исследования и публикации
                    </h1>
                    <h2>
                        <?=$model->category->translation->title?>
                    </h2>

                </div>
                <div>
                    <p href="" class="blue-link">
                        <?=$model->translation->title?>
                    </p>
                    <img src="<? if ($model->preview_image != null) echo $model->getThumbImage('preview_image', 100, 100);?>" alt="" class="news-details__img">

                    <p>
                        <?=$model->translation->full_text;?>
                    </p>
                    <p class="date">
                        <?php if ($model->published_at != null) echo date('d.m.y', $model->published_at );?>
                    </p>
                </div>

                <?= \app\modules\article\frontend\widgets\SeeAlsoWidget::widget(['categoryId' => $model->category_id, 'exclude' => [$model->id], 'menu' => $menu]);?>

            </section>
            <?
            switch($menu)
            {
                case 'leadership':
                    $parent_id = 6;
                    break;
                case 'peptides':
                    $parent_id = 8;
                    break;
                case 'cosmetics':
                    $parent_id = 10;
                    break;
                case 'publics':
                    $parent_id = 11;
                    break;

                default:
                    $parent_id = 0;
                    break;
            }?>


            <nav class="page-menu">
                <ul>
                    <?
                    echo \app\modules\menu\frontend\widgets\Menu::widget([
                        'menu_id' => 3,
                        'parent_id' => $parent_id,
                        'level' => 5,
                        'itemOptions' => ['class' => 'page-menu__list-item'],
                    ]) ?>
                </ul>
            </nav>

        </div>
    </div>
</div>
