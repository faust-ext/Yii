
<?php
/* @var $model Page */
?>
<div class="product-page page">
    <div class="wrap">
        <div class="row">
            <section class="page-content">
                <div class="page-title">
                    <h1>
                        Пептидные биорегуляторы
                    </h1>
                    <a href="" class="blue-link">
                        Цитогены
                    </a>
                </div>


                <section class="product-preview">
                    <div class="row">
                        <div class="col product-img" style="background-image: url(<?=$model->getThumbImage('preview_image', 100, 100);?>);"></div>
                        <div class="col product-preview-descr">
                            <h1>
                                <?=$model->translation->title; ?>
                            </h1>
                            <ul class="product-preview__menu-list">
                                <li class="product-preview__menu-item">
                                    <a href="">
                                        Описание
                                    </a>
                                </li>
                                <li class="product-preview__menu-item">
                                    <a href="#consist">
                                        Состав
                                    </a>
                                </li>
                                <li class="product-preview__menu-item">
                                    <a href="#mode-of-application">
                                        Способ применения
                                    </a>
                                </li>
                                <li class="product-preview__menu-item">
                                    <a href="#clinical-studies">
                                        Клинические исследования
                                    </a>
                                </li>
                                <li class="product-preview__menu-item">
                                    <a href="#video">
                                        Видео
                                    </a>
                                </li>
                            </ul>
                            <p class="product-preview__art">
                                <i>
                                    Артикул: <?=$model->translation->articul; ?>
                                </i>
                            </p>
                            <p class="product-preview__form">
                                <i>
                                    Форма выпуска: <?=$model->translation->form; ?>
                                </i>
                            </p>
                            <p class="product-preview__text">
                                <?=$model->translation->title; ?>
                            </p>
                        </div>
                    </div>
                </section>

                <section class="product-descr-dlock" id="consist">
                    <h3>
                        Состав
                    </h3>
                    <p>
                        <?=$model->translation->structure; ?>
                    </p>
                </section>

                <section class="product-descr-dlock" id="mode-of-application">
                    <h3>
                        Способ применения
                    </h3>
                    <p>
                        <?=$model->translation->app; ?>
                    </p>
                </section>

                <section class="product-descr-dlock" id="clinical-studies">
                    <h3>
                        Клинические исследования
                    </h3>
                    <p>
                        <?=$model->translation->searching; ?>
                    </p>
                </section>

                <div class="product-descr-dlock product-descr-video" id="video">
                    <h3>
                        Видеоматериалы
                    </h3>
                    <p>
                        Видеолекция Горгиладзе Д. А.
                    </p>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/3VM8wME0GEk" frameborder="0" allowfullscreen></iframe>
                </div>



                <div class="see-also">
                    <h3>
                        Смотрите также
                    </h3>
                    <div class="row">
                        <div class="text-block text-block--img col col-6">
                            <a href="product-card.html"><img src="/assets/images/chito.png" alt=""></a>
                            <div class="text-block__content">
                                <a href="product-card.html" class="blue-link">
                                    Везуген
                                </a>
                                <p>
                                    Последовательность нуклеотидов позволяет «кодировать» информацию.
                                </p>
                            </div>
                        </div>

                        <div class="text-block text-block--img col col-6">
                            <a href="product-card.html"><img src="/assets/images/chito.png" alt=""></a>
                            <div class="text-block__content">
                                <a href="product-card.html" class="blue-link">
                                    Карталакс
                                </a>
                                <p>
                                    Последовательность нуклеотидов позволяет «кодировать» информацию.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <nav class="page-menu">
                <ul>
                    <li class="page-menu__list-item active">
                        <a href="leadership.html">
                            Cинтезированные пептиды — цитогены
                        </a>
                    </li>
                    <li class="page-menu__list-item page-menu__list-item--lvl2">
                        <a href="">
                            Как принимать
                        </a>
                    </li>
                    <li class="page-menu__list-item page-menu__list-item--lvl2">
                        <a href="">
                            Схемы комплексного применения
                        </a>
                    </li>
                    <li class="page-menu__list-item">
                        <a href="">
                            Натуральные пептиды — цитомаксы
                        </a>
                    </li>
                    <li class="page-menu__list-item page-menu__list-item--lvl2">
                        <a href="">
                            Как принимать
                        </a>
                    </li>
                    <li class="page-menu__list-item page-menu__list-item--lvl2">
                        <a href="">
                            Схемы комплексного применения
                        </a>
                    </li>
                    <li class="page-menu__list-item ">
                        <a href="news.html">
                            Разработка лекарственных средств
                        </a>
                    </li>
                    <li class="page-menu__list-item ">
                        <a href="news.html">
                            Механизм действия
                        </a>
                    </li>
                    <li class="page-menu__list-item ">
                        <a href="news.html">
                            Безопасность применения
                        </a>
                    </li>
                    <li class="page-menu__list-item ">
                        <a href="news.html">
                            Где приобрести
                        </a>
                    </li>
                    <li class="page-menu__list-item page-menu__list-item--lvl2">
                        <a href="">
                            Россия
                        </a>
                    </li>
                    <li class="page-menu__list-item page-menu__list-item--lvl2">
                        <a href="">
                            Великобритания
                        </a>
                    </li>
                    <li class="page-menu__list-item page-menu__list-item--lvl2">
                        <a href="">
                            Австралия
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>