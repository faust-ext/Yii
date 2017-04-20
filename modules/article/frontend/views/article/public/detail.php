<div class="news-details-page page">
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
                    <a href="news.html" class="return">Все новости и события</a>
                </div>
                <div>
                    <p href="" class="blue-link">
                        <?=$model->translation->title;?>
                    </p>
                    <img src="<?=$model->getThumbImage('preview_image', 100, 100);?>" alt="" class="news-details__img">

                    <p>
                        <?=$model->translation->full_text; ?>
                    </p>
                    <p class="date">
                        <?php if ($model->published_at != null) echo date('d.m.y', $model->published_at );?>
                    </p>
                </div>


                <div class="see-also">
                    <div class="row">
                        <?= \app\modules\article\frontend\widgets\SeeAlsoWidget::widget(['categoryId' => $model->category_id, 'exclude' => [$model->id]]);?>
                    </div>
                </div>
            </section>

            <nav class="page-menu">
                <ul>
                    <li class="page-menu__list-item">
                        <a href="leadership.html">
                            Руководство компании
                        </a>
                    </li>
                    <li class="page-menu__list-item">
                        <a href="">
                            История компании
                        </a>
                    </li>
                    <li class="page-menu__list-item active">
                        <a href="news.html">
                            Новости и события
                        </a>
                    </li>
                    <li class="page-menu__list-item">
                        <a href="" class="page-menu-link">
                            Партнёры
                        </a>
                    </li>
                </ul>
            </nav>

            <ui class="paginator">
                <li class="paginator__item">1</li>
                <li class="paginator__item active">2</li>
                <li class="paginator__item">3</li>
                <li class="paginator__item">4</li>
            </ui>
        </div>
    </div>
</div>