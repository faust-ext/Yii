<div class="peptides-page page">
    <div class="wrap">
        <div class="row">
            <section class="page-content">
                <div class="page-title">
                    <h1>
                        <?= $category->translation->title;  ?>
                    </h1>
                </div>

                <p>
                    <?=$category->translation->description?>

                </p>

                <?php
                foreach($model->children as $category) {?>
                    <div class="text-block text-block--img">
                        <img src="<?=$category->getThumbImage('image', 100, 100);?>" alt="">
                        <div class="text-block__content">
                            <?switch($parent_id)
                            {
                                case 6:
                                    $menu_id = 'leadership';
                                    break;
                                case 8:
                                    $menu_id = 'peptides';
                                    break;
                                case 10:
                                    $menu_id = 'cosmetics';
                                    break;
                                case 11:
                                    $menu_id = 'publics';
                                    break;
                                default:
                                    break;
                            }?>
                            <a href="<?= \yii\helpers\Url::to(['/article/article/index', 'alias' => $category->alias, 'menu' => $menu_id])?>" class="blue-link">
                                <?=$category->translation->title; ?>
                            </a>
                            <p>
                                <?=$category->translation->description; ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>



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