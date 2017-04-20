<div class="public-page page">
    <div class="wrap">
        <div class="row">
            <section class="page-content">
                <div class="page-title">
                    <h1>
                        Научные исследования и публикации
                    </h1>
                    <h2>
                        <?=$category->translation->title?>
                    </h2>
                </div>


                <div class="text-block">
                    <?= \yii\widgets\ListView::widget([
                        'dataProvider' => $dataProvider,
                        'viewParams' => ['parent_id' =>$parent_id],
                        'itemView' => '_view',
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
