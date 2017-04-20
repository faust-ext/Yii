</div>
<div class="contact-page page">
    <div class="wrap">
        <div class="row">
            <section class="page-content">
                <?= $model->translation->text ?>


<?if ($model->id != 2){?>

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
<? } else {?>
 <div id="map_canvas" title="ул. Красного Курсанта, 25" data-x="59.959725" data-y="30.281485" data-zoom="16" data-places="[ [59.959725,30.281485] , [59.959725,30.281485] ]">

                </div>
                    </section>

    <?php $model = new \app\modules\page\common\models\Mail;
    $form = \yii\widgets\ActiveForm::begin([
            'id' => 'form',
            'options' => ['class' => "contact-form", 'style'=> "display: none; width: 490px;"],
            'action' => \yii\helpers\Url::to(['/core/site/mail']),
            'fieldConfig' => [
                'template' => '<p>{label}{input}</p>',
                'labelOptions' => ['class' => 'name'],
            ],
        ]
    );?>
    <h3><?=Yii::t('app', 'Обратная связь');?> </h3>
            <div class="form-content">
   <?=$form->field($model, 'name')->textInput([ 'class'=>"input-control"])->label(Yii::t('app', 'Ф.И.О.'));?>
   <?= $form->field($model, 'email')->input('email', ['class'=>"input-control input-mail" ])->label(Yii::t('app', 'Эл.почта'));?>
   <?= $form->field($model, 'phone')->input('phone', ['class'=>"input-control input-phone"])->label(Yii::t('app', 'Телефон'));?>
   <?= $form->field($model, 'text')->textarea(['class' => 'cloud-text' ])->label(Yii::t('app', 'Сообщение'));?>


                </div>
    <input type="submit" value="<?=Yii::t('app', 'Отправить');?>" class="form-blue-button">
    <?php
    \yii\widgets\ActiveForm::end(); ?>
    <a href="thanks" class="fancybox"></a>


    <div id="thanks" class="contact-form thanks" style="display: none; width: 490px;">
        <h3><?= Yii::t('app', 'Обратная связь')?></h3>
        <p class="thanks-text">
        <?= Yii::t('app', 'Спасибо за ваш вопрос!')?> <br>
            <?= Yii::t('app', 'Ответ будет оправлен на ваш E-mail')?>
        </p>

        <p class="form-blue-button">Ок</p>
    </div>

    <nav class="page-menu">
        <ul>
            <li class="page-menu__list-item">
                <a href="#form" class="fancybox">
                    <?= Yii::t('app', 'Обратная связь')?>
                </a>
            </li>
        </ul>
    </nav>
<?}?>

        </div>
    </div>
</div>