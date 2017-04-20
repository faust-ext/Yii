<?php
/* @var $this yii\web\View */
/* @var $model app\modules\article\common\models\Category */

?>

<div class="about-page page">
    <div class="wrap">
        <div class="row">
            <section class="page-content">
                <div class="page-title">
                    <h1>
                        О компании
                    </h1>

                    <h2>
                        <?= $category->translation->title ?>
                    </h2>
                </div>

                <?= \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_view'
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