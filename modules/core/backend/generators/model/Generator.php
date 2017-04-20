<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\core\backend\generators\model;

use Yii;
use yii\gii\CodeFile;

/**
 * This generator will generate one or multiple ActiveRecord classes for the specified database table.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\generators\model\Generator
{
    public $langModelClass, $langTableName, $langColumn;
    public $useTablePrefix = true;
    public $ns = 'app\modules\moduleName\common\models';
    public $baseClass = 'app\modules\core\common\components\ActiveRecord';

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Lang model Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator generates Lang Models.';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['langModelClass', 'langTableName', 'langColumn'], 'required'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function autoCompleteData()
    {
        $db = $this->getDbConnection();
        if ($db !== null) {
            $data = [
                'langTableName' => function () use ($db) {
                    return $db->getSchema()->getTableNames();
                },
            ];
        } else {
            $data = [];
        }

        return array_merge(parent::autoCompleteData(), $data);
    }


    public function generate()
    {
        $files = [];

        $tableNames = [
            'langs' => 'Lang',
            $this->tableName => $this->modelClass,
            $this->langTableName => $this->langModelClass,
        ];

        $this->classNames = $tableNames;

        $files = array_merge($files, parent::generate());

        $langGenerator = new \yii\gii\generators\model\Generator();
        $langGenerator->attributes = $this->attributes;
        $langGenerator->modelClass = $this->langModelClass;
        $langGenerator->tableName = $this->langTableName;
        $langGenerator->tableNames[] = $this->langTableName;
        $langGenerator->classNames = $tableNames;

        $files = array_merge($files, $langGenerator->generate());

        $files[] = new CodeFile(
            Yii::getAlias('@' . str_replace('\\', '/', $this->ns)) . '/' . $this->modelClass . 'Query.php',
            $this->render('query.php')
        );

        return $files;
    }
}
