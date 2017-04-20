<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\modules\core\frontend\assets\AppAsset;
use app\modules\core\common\models\Lang;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

$this->registerJsFile('http://maps.google.com/maps/api/js?sensor=false');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=980" />
    <title>
        Site
    </title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="shortcut icon" href="/images/favicon.png" />
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="/css/camera.css" type="text/css">
    <style>
        *{
            margin:0;
            padding: 0;
        }
        #MainSlider .camera_effected {
            width: 1088px;
            margin: 0 auto;
            position: relative;
            text-align: left;
            color: #fff;
        }

        #MainSlider  .camera_prev {
            left: 70px;
            background: none;
        }

        #MainSlider  .camera_prev span{
            background: url('/images/sprite/arr-prev.png') no-repeat center center;
        }

        #MainSlider  .camera_prev:hover span{
            background: url('/images/sprite/arr-prev-g.png') no-repeat center center;
        }

        #MainSlider  .camera_next {
            right: 70px;
            background: none;
        }

        #MainSlider  .camera_next span{
            background: url('/images/sprite/arr-next.png') no-repeat center center;
        }

        #MainSlider  .camera_next:hover span{
            background: url('/images/sprite/arr-next-g.png') no-repeat center center;
        }

        #MainSlider .camera_effected .wrap-caption {
            width: 450px;
            float: right;
            margin-top: 75px;
        }

        #MainSlider .camera_effected .slider-header{
            font-size: 34px;
            font-weight: bold;
            margin-bottom: 30px;

        }

        #MainSlider .camera_effected .slider-desc {
            font-size: 14px;
            width: 450px;
        }

        #MainSlider .camera_pag {
            position: absolute;
            z-index: 1000;
            bottom: 10%;
            left: 55%;
        }

        .camera_wrap .camera_pag .camera_pag_ul li {
            background: #fff;
        }

        .camera_wrap .camera_pag .camera_pag_ul li.cameracuharrent {
            background: #9cbe13;
        }

        .camera_wrap .camera_pag .camera_pag_ul li > span {
            display: none;
        }

    </style>
</head>
<body>
<?php $this->beginBody() ?>
<?
if ($this->context->id == 'site' && $this->context->action->id == 'index') {?>
<header id="header" class="header--index">
    <?} else {?>
    <header id="header" class="header">
        <?}?>
        <div class="wrap">
            <div class="header-top">
                <div class="header-top--left">
                    <a href="<?= \yii\helpers\Url::to(['/core/site/index'])?>">
                        <img src="/images/logo.png" alt="">
                    </a>
                </div>
                <div class="header-top--right">
                   <form action="<?= \yii\helpers\Url::to(['/core/site/search']);?>" class="header-form">
                        <input type="search" name = "query" id="query" required>
                        <input type="submit" class="sprite sprite-search">
                    </form>
                    <div class="languages">
                        <?= \app\modules\core\frontend\widgets\LangSwitcher::widget(); ?>
                       <!--<a href="" class="active language language--ru">RU</a>
                        <a href="" class="language language--en">EN</a>-->
                    </div>
                </div>
            </div>
            <nav class="header-menu">
                <?= \app\modules\menu\frontend\widgets\Menu::widget(['menu_id' => 3,
                    'parent_id' => null,
                    'level'=>1,
                    'itemOptions' => ['class' => 'header-item']]);?>
            </nav>
        </div>

    </header>
    <section id="content" class="content">

        <?= $content ?>

    </section>

    <div class="up">
        <div class="wrap">
            <a href="#header" class="up__child">
                <i class="sprite sprite-arr-up"></i>
                <p>наверх</p>
            </a>
        </div>

    </div>
    <footer id="footer" class="footer">
        <div class="wrap footer-colums">
            <div class="row">
                <div class="col col-3">
                    <h3 class="footer-colum--title"><?= Yii::t('app', 'О компании')?></h3>
                    <?= \app\modules\menu\frontend\widgets\Menu::widget(['menu_id' => 3, 'parent_id' => 6, 'level' => 1, 'itemOptions' => ['class' => 'footer-link'], 'options' => ['class' => 'footer-link']]);?>
                </div>
                <div class="col col-3">
                    <h3 class="footer-colum--title"><?= Yii::t('app', 'Пептидные биорегуляторы')?></h3>
                    <?= \app\modules\menu\frontend\widgets\Menu::widget(['menu_id' => 3, 'level' => 1, 'parent_id' => 8, 'itemOptions' => ['class' => 'footer-link']]);?>
                </div>
                <div class="col col-3">
                    <h3 class="footer-colum--title"><?= Yii::t('app', 'Научные исследования')?></h3>
                    <?= \app\modules\menu\frontend\widgets\Menu::widget(['menu_id' => 3, 'level' => 1,'parent_id' => 11, 'itemOptions' => ['class' => 'footer-link']]);?>
                </div>
                <div class="col col-3">
                    <h3 class="footer-colum--title"><?= Yii::t('app', 'Косметическая линия')?></h3>
                    <?= \app\modules\menu\frontend\widgets\Menu::widget(['menu_id' => 3, 'level' => 1,'parent_id' => 10, 'itemOptions' => ['class' => 'footer-link']]);?>
                </div>
<!--                <div class="col col-2">-->
<!--                    <h3 class="footer-colum--title">Отзывы</h3>-->
<!--                    --><?//= \app\modules\menu\frontend\widgets\Menu::widget(['menu_id' => 8, 'level' => 2,  'itemOptions' => ['class' => 'footer-link']]);?>
<!--                </div>-->
<!--                <div class="col col-2">-->
<!--                    <h3 class="footer-colum--title">Интеллектуальная собственность</h3>-->
<!--                    --><?//= \app\modules\menu\frontend\widgets\Menu::widget(['menu_id' => 9, 'level' => 2,  'itemOptions' => ['class' => 'footer-link']]);?>
<!--                </div>-->
            </div>
        </div>
        <div class="footer-bottom">
            <div class="wrap">
                <div class="footer-bottom--left">
                    <p>
                        © <?= Yii::t('app', 'Гармония 1992–2014')?> <br>
                        <?= Yii::t('app', 'г. Санкт-Петербург, ул. Красного Курсанта, д.25, лит Ж')?>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
    <script src="/js/libs/jquery-migrate-1.2.1.min.js"></script>
    <script src="/js/libs/jquery.easing.1.3.js"></script>
    <script src="/js/libs/slider.js"></script>
    <script>

        $(document).ready(function(){

            $('#MainSlider').camera({ //here I declared some settings, the height and the presence of the thumbnails
                height: '360px',
                loader: 'none',
                playPause: false,
                pagination: true,
                thumbnails: false,
                fx: "scrollLeft",
            });

        });

    </script>
</body>
</html>

<?php $this->endPage() ?>
