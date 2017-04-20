<div class="intprop-page page">
    <div class="wrap">
        <div class="row">
            <section class="page-content">
                <div class="page-title">
                    <h1>
                        <?=$type_menu;?>
                    </h1>
                    <h2>
                        <?=$category->translation->title?>
                    </h2>
                </div>

                <p>
                    <?=$category->translation->description;?>
                </p>

                <?= \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_view',
                    'viewParams' => ['parent_id' =>$patents_menu_id],
                    'itemOptions' => ['class' => 'text-block text-block--img'],
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
                        'menu_id' => $patents_menu_id,
                       // 'parent_id' => $parent_id,
                        'level' => 5,
                        'itemOptions' => ['class' => 'page-menu__list-item'],
                    ]) ?>
                </ul>
            </nav>
        </div>
    </div>
</div>
