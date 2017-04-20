<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\core\frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        "js/libs/jquery-1.10.2.min.js",
        "js/libs/jquery-stick-footer.js",
        "js/libs/jquery.placeholder.js",
        "js/libs/jquery.inputmask.js",
        "js/libs/jquery.scrollTo-1.4.3.1-min.js",
        "js/libs/jquery.mousewheel.min.js",
        "js/libs/fancybox/jquery.fancybox.pack.js",
        "js/libs/jquery.bxslider.min.js",
        "js/libs/jquery.tabslet.min.js",
        "js/libs/jquery.dotdotdot.min.js",
        "js/utils.js",
        "js/init.js",
    ];
    public $depends = [
        //'yii\web\YiiAsset',
       // 'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
        'yii\widgets\PjaxAsset'
    ];
}
