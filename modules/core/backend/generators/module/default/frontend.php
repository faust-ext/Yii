<?php
/**
 * This is the template for generating a module class file.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */

$className = $generator->moduleClass;
$pos = strrpos($className, '\\');
$ns = ltrim(substr($className, 0, $pos), '\\');
$className = substr($className, $pos + 1);

echo "<?php\n";
?>

namespace <?= $ns ?>;

use yii\base\BootstrapInterface;

class <?= $className ?> extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = '<?= $generator->getControllerNamespace() ?>';

    public function bootstrap($app)
    {
            $app->getUrlManager()->addRules(
                require(__DIR__ . '/config/routes.php'),
                false);

        $app->params['yii.migrations'][] = '@app/modules/<?=$generator->moduleID;?>/migrations';
    }

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
