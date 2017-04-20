<div class="news-page page">
    <div class="wrap">
        <div class="row">
            <section class="page-content">
                <div class="page-title">
                    <h1>
                        О компании
                    </h1>
                    <h2>
                        Новости и события
                    </h2>
                </div>

                <? foreach($models as $article) {?>
                    <div class="text-block text-block--img">
                        <img src="<?=$article->getThumbImage('preview_image', 100, 100);?>" alt="">
                        <div class="text-block__content">
                            <a href="news_details.html" class="blue-link">
                                <?=$article->translation->title; ?>
                            </a>
                            <?=$article->translation->intro_text; ?>
                            <p class="date">
                                <?php if ($article->published_at != null) echo date('d.m.y', $article->published_at );?>
                            </p>
                        </div>
                    </div>
                <?php } ?>

            </section>


            <nav class="page-menu">
                <ul>
                    <?= \app\modules\menu\frontend\widgets\SideMenu::widget(['item_class' => 'page-menu__list-item', 'menu_id' => 4]);?>
                </ul>
            </nav>
            <?php
            echo \yii\widgets\LinkPager::widget([
                'options' => ['class' => 'paginator'],
                'pagination' => $pages,
                'activePageCssClass' => 'active',
                'nextPageLabel' => false,
                'prevPageLabel' => false,

            ]);
            ?>


            <ui class="paginator">
                <li class="paginator__item">1</li>
                <li class="paginator__item active">2</li>
                <li class="paginator__item">3</li>
                <li class="paginator__item">4</li>
            </ui>
        </div>

    </div>

</div>
