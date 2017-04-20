<div class="cosmetics-page page">
    <div class="wrap">
        <div class="row">
            <section class="page-content">
                <div class="page-title">
                    <h1>
                        Косметическая линия
                    </h1>
                    <h2>

                    </h2>
                </div>

                <p>
                    <?=$category->translation->description;?>
                </p>

                <div class="row wrap-text-blocks">
                    <?= \yii\widgets\ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemView' => '_view',
                        'itemOptions' => ['class' => 'paginator']
                    ]); ?>

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
            </section>



            <ui class="paginator">
                <li class="paginator__item">1</li>
                <li class="paginator__item active">2</li>
                <li class="paginator__item">3</li>
                <li class="paginator__item">4</li>
            </ui>
        </div>
    </div>
</div>
