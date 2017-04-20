<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\core\backend\generators\module;

use Yii;
use yii\gii\CodeFile;
use yii\helpers\StringHelper;

/**
 * This generator will generate the skeleton code needed by a module.
 *
 * @property string $controllerNamespace The controller namespace of the module. This property is read-only.
 * @property boolean $modulePath The directory that contains the module class. This property is read-only.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\generators\module\Generator
{
    public $moduleClass = 'Module';
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Bro Module Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'Module for PHPBrothers CMS';
    }

    /**
     * @inheritdoc
     */
    public function requiredTemplates()
    {
        return ['module.php'];
    }

    public function rules()
    {
        return [
            [['moduleID'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $files = [];
        $this->moduleClass = 'app\\modules\\' . $this->moduleID . '\\frontend\\' . $this->moduleClass;
        $modulePath = $this->getModulePath();
        $files[] = new CodeFile(
            $modulePath . '/' . StringHelper::basename($this->moduleClass) . '.php',
            $this->render("frontend.php")
        );

        $files[] = new CodeFile(
            $modulePath . '/config/routes.php',
            $this->render("routes.php")
        );

        $this->moduleClass = 'app\\modules\\' . $this->moduleID . '\\backend\\' . StringHelper::basename($this->moduleClass);
        $modulePath = $this->getModulePath();
        $files[] = new CodeFile(
            $modulePath . '/' . StringHelper::basename($this->moduleClass) . '.php',
            $this->render("backend.php")
        );

        $files[] = new CodeFile(
            $modulePath . '/config/routes.php',
            $this->render("routes.php")
        );

        return $files;
    }
}
