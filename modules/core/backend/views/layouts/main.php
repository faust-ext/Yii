<?php
use yii\helpers\Html;
use app\modules\core\backend\widgets\TreeNav;
use yii\widgets\Breadcrumbs;
use app\modules\core\backend\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
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
    <body class="skin-yellow">

    <?php $this->beginBody() ?>

    <!-- Site wrapper -->
    <div class="wrapper">

        <header class="main-header">
            <a href="<?= Yii::$app->homeUrl; ?>" class="logo"><b>PHPBrothers</b>CMS</a>

            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
            </nav>
        </header>


        <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <p><?= Yii::$app->user->identity->username; ?></p>
<!--                        <img src="" class="img-circle" alt="User Image"/>-->
                    </div>
                    <div class="pull-left info">
                        <p><?= Yii::$app->user->identity->username; ?></p>

<!--                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
                    </div>
                </div>

                <?php echo TreeNav::widget([
                    'options'      => ['class' => 'sidebar-menu'],
                    'encodeLabels' => false,
                    'items'        => [
                        ['label' => 'Пользователи', 'url' => ['/user/user/index']],
                        [
                            'label'   => 'Меню',
                            'url'     => ['/menu/menu/index'],
                            'options' => ['class' => 'treeview'],
                            'active'  => $this->context->module->id == 'menu',
                            'items'   => [
                                [
                                    'label'  => 'Типы меню',
                                    'url'    => ['/menu/menu/index'],
                                    'active' => $this->context->module->id == 'menu' && $this->context->id == 'menu',

                                ],
                                [
                                    'label'  => 'Элементы',
                                    'url'    => ['/menu/item/index'],
                                    'active' => $this->context->module->id == 'menu' && $this->context->id == 'item',
                                ],
                            ]
                        ],
                        [
                            'label'   => 'Статьи',
                            'url'     => ['/article/article/index'],
                            'options' => ['class' => 'treeview'],
                            'active'  => $this->context->module->id == 'article',
                            'items'   => [
                                [
                                    'label'  => 'Статьи',
                                    'url'    => ['/article/article/index'],
                                    'active' => $this->context->module->id == 'article' && $this->context->id == 'article',

                                ],
                                [
                                    'label'  => 'Категории',
                                    'url'    => ['/article/category/index'],
                                    'active' => $this->context->module->id == 'article' && $this->context->id == 'category',
                                ],
                            ]
                        ],
                        ['label' => 'Вопросы и ответы', 'url' => ['/feedback/feedback/index']],
                        ['label' => 'Страницы', 'url' => ['/page/page/index']],
                            [
                                'label'       => 'Выход',
                                'url'         => ['/user/user/logout'],
                                'linkOptions' => ['data-method' => 'post']
                            ],
                    ],
                ]); ?>
            </section>
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?= $this->title; ?>
                    <small><?= $this->subTitle; ?></small>
                </h1>

                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <?= \app\modules\core\backend\widgets\Alert::widget(); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            <?php
                            if (isset($this->params['menu'])) {
                                foreach ($this->params['menu'] as $menuItem) {
                                    echo Html::a($menuItem['label'], $menuItem['url'],
                                            isset($menuItem['options']) ? $menuItem['options'] : []) . "\n";
                                }
                            } ?>
                        </p>
                    </div>
                    <!-- /.col1 -->
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <?= $content ?>
                    </div>
                    <!-- /.col2 -->
                </div>
            </section>
        </div>
    </div>



    <?php /*
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'My Company',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => Yii::$app->homeUrl],
                    ['label' => 'Users', 'url' => ['/user/index']],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Login', 'url' => ['/user/login']] :
                        ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/user/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

*/ ?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>