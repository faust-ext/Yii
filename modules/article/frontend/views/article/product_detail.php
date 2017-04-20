<div class="product-page page">
    <div class="wrap">
        <div class="row">
            <section class="page-content">
                <div class="page-title">
                    <h1>
                        <?=$menu_name;?>
                    </h1>

                    <h2> <?=$model->category->translation->title?> </h2>


                </div>
                <?= $model->translation->full_text?>
            </section>

            <? if ($parent_id == 'intprop') {
                $menu_id = 9;
                $parent_id = null;
            }
                elseif ($parent_id == 'patents')
                {
                    $menu_id = 8;
                    $parent_id = null;
                }
            else {
                $menu_id = 3;
                switch ($parent_id) {
                    case 'leadership':
                        $parent_id = 6;
                        break;
                    case 'peptides':
                        $parent_id = 8;
                        break;
                    case 'cosmetics':
                        $parent_id = 10;
                        break;
                    case 'publics':
                        $parent_id = 11;
                        break;
                    default:
                        $parent_id = 0;
                        break;
                }
            }

            ?>

            <nav class="page-menu">
                <ul>
                    <?
                    echo \app\modules\menu\frontend\widgets\Menu::widget([
                        'menu_id' => $menu_id,
                        'parent_id' => $parent_id,
                        'level' => 5,
                        'itemOptions' => ['class' => 'page-menu__list-item'],
                    ]) ?>
                </ul>
            </nav>
        </div>
    </div>
</div>