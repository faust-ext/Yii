<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator app\modules\core\backend\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

$className = $generator->modelClass;

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;
use app\modules\core\common\models\Status;
use yii\db\ActiveQuery;

class <?= $className ?>Query extends ActiveQuery
{

    public function init()
    {
        parent::init();
        $this->where(['!=', <?= $className ?>::tableName() . '.status', Status::ERASED]);
    }

    public function active($state = true)
    {
        $this->andWhere([<?= $className ?>::tableName() . '.status' => $state ? Status::ACTIVE : Status::DELETED]);
        return $this;
    }

}
