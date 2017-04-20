<? $this->title = 'index' ?>
<div class="index-page page">
    <div id="MainSlider" class="camera_wrap">
        <?
        foreach ($slider as $slide) : ?>
            <div data-src="<?= $slide->getFullImage('preview_image') ?>">
                <div class="fadeIn camera_effected">
                    <div class="wrap-caption">
                        <div class="slider-header"><?= $slide->translation->title; ?></div>
                        <div class="slider-desc"><?= $slide->translation->intro_text; ?>
                        </div>
                    </div>
                </div>
            </div>
        <? endforeach; ?>
    </div>


    <div class="wrap">
        <div class="row">
            <div class="prewiev">
                <!--        <div class="wrap" style="margin-top: 250px;">-->
                <!--            <div class="row">-->
                <!--                <div class="prewiev-el prewiev__news-events-press col col-4 tabs-on">-->
                <!--                    <ul class="preview-el__list">-->
                <!--                        <li class="preview-el__item">-->
                <!--                            <a href="#prewiev-el__news">-->
                <!--                                Новости-->
                <!--                            </a>-->
                <!--                        </li>-->
                <!--                        <li class="preview-el__item">-->
                <!--                            <a href="#prewiev-el__events">-->
                <!--                                Мероприятия-->
                <!--                            </a>-->
                <!--                        </li>-->
                <!--                        <li class="preview-el__item">-->
                <!--                            <a href="#prewiev-el__press">-->
                <!--                                Пресса о нас-->
                <!--                            </a>-->
                <!--                        </li>-->
                <!--                    </ul>-->
                <!--                    <div id="prewiev-el__news">-->
                <!--                        --><? // foreach ($news as $new)
                //                        {?>
                <!--                            <a href="-->
                <? //= \yii\helpers\Url::to(['/article/article/view', 'id' => $new->id, 'menu' => 'leadership']) ?><!--" class="prewiev-el__nep-link">-->
                <!--                            <p class="date">-->
                <!--                                --><?php //if ($new->published_at != null) echo date('d.m.y', $new->published_at );?>
                <!--                        </p>-->
                <!--                            <p class="prewiev-el__nep-link__text">-->
                <!--                                --><? //=$new->translation->title; ?>
                <!--                        </p>-->
                <!--                        </a>-->
                <!--                       --><? // }?>
                <!--                       <a href="--><? //
                //                       foreach ($menuItems as $menuItem)
                //                       {
                //                           if ($menuItem->id == 14)
                //                               echo $menuItem->getUrlTo();
                //
                //                       }
                //                       ?><!--" class="link-to-all">-->
                <!--                            Все новости-->
                <!--                        </a>-->
                <!--                    </div>-->
                <!--                    <div id="prewiev-el__events">-->
                <!--                        --><? // foreach ($actions as $action) {?>
                <!--                        <a href="-->
                <? //= \yii\helpers\Url::to(['/article/article/view', 'id' => $action->id, 'menu' => 'leadership']) ?><!--" class="prewiev-el__nep-link">-->
                <!--                            <p class="date">-->
                <!--                                --><?php //if ($action->published_at != null) echo date('d.m.y', $action->published_at );?>
                <!--                            </p>-->
                <!--                            <p class="prewiev-el__nep-link__text">-->
                <!--                                --><? //=$action->translation->title; ?>
                <!--                            </p>-->
                <!--                        </a>-->
                <!--                        --><? // }?>
                <!--                        <a href="--><? //
                //                        foreach ($menuItems as $menuItem)
                //                        {
                //                            if ($menuItem->id == 11)
                //                                echo $menuItem->getUrlTo();
                //
                //                        }
                //                        ?><!--" class="link-to-all">-->
                <!--                            Все мероприятия-->
                <!--                        </a>-->
                <!--                    </div>-->
                <!--                    <div id="prewiev-el__press">-->
                <!--                        --><? // foreach ($presses as $press) {?>
                <!--                            <a href="-->
                <? //= \yii\helpers\Url::to(['/article/article/view', 'id' => $press->id, 'menu' => 'leadership']) ?><!--" class="prewiev-el__nep-link">-->
                <!--                                <p class="date">-->
                <!--                                    --><?php //if ($press->published_at != null) echo date('d.m.y', $press->published_at );?>
                <!--                                </p>-->
                <!--                                <p class="prewiev-el__nep-link__text">-->
                <!--                                    --><? //=$press->translation->title; ?>
                <!--                                </p>-->
                <!--                            </a>-->
                <!--                        --><? // }?>
                <!--                        <a href="--><? //
                //                        foreach ($menuItems as $menuItem)
                //                        {
                //                            if ($menuItem->id == 10)
                //                                echo $menuItem->getUrlTo();
                //
                //                        }
                //                        ?><!--" class="link-to-all">-->
                <!--                            Все статьи-->
                <!--                        </a>-->
                <!--                    </div>-->
                <!--                </div>-->


                <div class="prewiev-el prewiev__publick col col-9">
                    <h4 class="prewiev-el-title">
                        <span>Научные исследования и публикации</span>
                    </h4>
                    <? foreach ($publics as $public) { ?>
                        <div class="text-block text-block--img">
                            <a href="<?= \yii\helpers\Url::to([
                                '/article/article/view',
                                'id' => $public->id,
                                'menu' => 'publics'
                            ]) ?>"><img src="<? if ($public->preview_image != null) {
                                    echo $public->getThumbImage('preview_image', 100, 100);
                                } ?>" alt=""></a>

                            <div class="text-block__content">
                                <a href="<?= \yii\helpers\Url::to([
                                    '/article/article/view',
                                    'id' => $public->id,
                                    'menu' => 'publics'
                                ]) ?>" class="text-block-link">
                                    <?= $public->translation->title; ?>
                                </a>

                                <p>
                                    <?= $public->translation->intro_text; ?>
                                </p>
                            </div>
                        </div>
                    <? } ?>
                    <a href="<?= \yii\helpers\Url::to(['/article/article/index', 'alias' => 'public']) ?>"
                       class="link-to-all">
                        Все публикации
                    </a>
                </div>


                <div class="prewiev-el prewiev__product col col-3">
                    <h4 class="prewiev-el-title">
                        <span>Продукция</span>
                    </h4>

                    <div class="prewiev__product-block">
                        <a href="<?= \yii\helpers\Url::to([
                            '/article/article/view',
                            'id' => $product->id,
                            'menu' => 'peptides'
                        ]) ?>">
                            <img src="<? if ($product->preview_image != null) {
                                echo $product->getFullImage('preview_image');
                            } ?>" alt="">
                        </a>
                        <a href="<?= \yii\helpers\Url::to([
                            '/article/article/view',
                            'id' => $product->id,
                            'menu' => 'peptides'
                        ]) ?>" class="prewiev__product-title">
                            <?= $product->translation->title; ?>
                        </a>

                        <p class="prewiev__product-text">
                            <?= $product->translation->intro_text; ?>
                        </p>
                    </div>

                    <a href="<?= \yii\helpers\Url::to([
                        '/article/article/index',
                        'alias' => $product->category->alias,
                        'menu' => 'peptides'
                    ]) ?>" class="link-to-all">
                        Продукция
                    </a>
                </div>
            </div>
        </div>
    </div>


<section class="short-descr">
    <div class="wrap">
        <div class="row">
            <div class=" col col-9">
                <h1>Компания</h1>

                <p class="short-descr--text">
                    Санкт-Петербургский Институт биорегуляции и геронтологии организован в 1992 г. с целью реализации
                    фундаментальных и прикладных задач в области биорегуляции и геронтологии и внедрения в медицинскую
                    практику результатов экспериментальных и клинических исследований нового класса лекарственных
                    препаратов пептидных биорегуляторов, созданных в научно-исследовательской лаборатории биорегуляторов
                    Военно-медицинской академии им. С.М. Кирова
                </p>
            </div>
            <blockquote class="col col-3">
                <p>
                    В 2001 г. Институт вошел в состав Северо-Западного отделения Российской академии медицинских наук.
                </p>
            </blockquote>
        </div>
    </div>
</section>
<!--    <section class="index-page__intel-prop">-->
<!--        <div class="wrap">-->
<!--            <h1>Интеллектуальная собственность</h1>-->
<!--            <div class="row">-->
<!--                <div class="clearfix">-->
<!--                    --><? //foreach ($intels as $intel)
//                    {?>
<!--                    <div class="col-4 col">-->
<!--                        <a href="--><? //= \yii\helpers\Url::to(['/article/article/index', 'alias' => $intel->alias]) ?><!--">-->
<!--                            <h3>--><? //=$intel->translation->title?><!--</h3>-->
<!--                        </a>-->
<!--                        <p>-->
<!--                            --><? //=$intel->translation->description?>
<!--                        </p>-->
<!--                    </div>-->
<!--                    --><? //}?>
<!--                </div>-->
<!--            </div>-->
<!---->
<!--        </div>-->
<!--    </section>-->

</div>