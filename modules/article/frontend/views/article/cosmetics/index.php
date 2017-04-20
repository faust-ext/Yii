<div class="cosmetics-page page">
    <div class="wrap">
        <div class="row">
            <section class="page-content">
                <div class="page-title">
                    <h1>
                        <?=$title?>
                    </h1>
                    <h2>
                        <?=$category->translation->title;?>
                    </h2>
                </div>

                <p>
                    <?=$category->translation->description;?>
                </p>


                <div class="row wrap-text-blocks">
                    <?= \yii\widgets\ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemView' => '_view',
                        'viewParams' => ['parent_id' =>$parent_id],
                        'itemOptions' => ['class' => 'text-block text-block--img col col-6'],
                        'pager' => ['options' => ['class' => 'paginator'],
                            'prevPageLabel' => false,
                            'nextPageLabel' => false,
                        ]
                    ]); ?>



                    </div>
            </section>
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
