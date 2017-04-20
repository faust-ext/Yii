<?php
use app\modules\core\frontend\components\Highlighter;

?>

<div class="news-page page">
    <div class="wrap">
        <div class="row">
            <section class="page-content">
                <div class="page-title">
                    <h1>
                        Результаты поиска
                    </h1>

                </div>

                <?php

                //var_dump($rows); die();
                foreach ($rows as $i => $row) { ?>

                        <div class="text-block__content">

                            <a href="<?
                            if ($row['alias'] == null) {
                                echo \yii\helpers\Url::to(['/article/article/view', 'id' => $row['id'], 'menu' => $row['menu']]);
                            } else {
                                echo \yii\helpers\Url::to(['/article/article/'.$row['rowaction'], 'alias' => $row['alias'], 'menu' => $row['menu']]);
                            }
                            ?>" class="blue-link"
                                ><?= $row['title']; ?></a>



                            <?

                            if ($row['intro_text'] != null) {
                                echo $row['intro_text'];
                            } else {
                                if ($row['full_text'] != null && mb_stripos($row['full_text'], $query) !== false) {
                                    echo $row['full_text'];
                                }
                            }

                            ?>
                        </div>
                   
                <? } ?>


        </div>
    </div>
</div>
</section>