<div class="peptides-page page">
    <div class="wrap">
        <div class="row">
            <section class="page-content">
                <div class="page-title">
                    <h1>


                    </h1>
                </div>


                <p>
                </p>
                <p></p>
                <?= \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_view',
                    'itemOptions' => ['class' => 'text-block text-block--img col col-6'],
                    'pager' => ['options' => ['class' => 'paginator'],
                        'prevPageLabel' => false,
                        'nextPageLabel' => false,
                    ]
                ]); ?>


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