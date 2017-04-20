<?php
use yii\helpers\Html;
use app\modules\core\backend\widgets\TreeNav;
use yii\widgets\Breadcrumbs;
use app\modules\core\backend\assets\LoginAsset;

/* @var $this \yii\web\View */
/* @var $content string */

LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="login-page skin-yellow">

<?php $this->beginBody() ?>

<div class="login-box">
    <div class="login-logo">
        <a href="<?= Yii::$app->homeUrl; ?>"><b>PHPBrothers</b>CMS</a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Вход в панель администрирования</p>

        <?= $content ?>

    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->

<?php

$this->registerJs("
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-yellow',
            radioClass: 'iradio_square-yellow',
            increaseArea: '20%' // optional
        });
    });
"); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>