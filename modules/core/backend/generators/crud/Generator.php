<?php

namespace app\modules\core\backend\generators\crud;

use app\modules\core\backend\components\ARController;
use Yii;
use yii\gii\CodeFile;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Generator extends \yii\gii\generators\crud\Generator
{
    public $moduleName, $langModelClass, $moduleTitle;
    public $isLang = false;

    public function init()
    {
        parent::init();
        $this->baseControllerClass = ARController::className();
    }

    public function getName()
    {
        return 'Backend CRUD Generator';
    }

    public function getDescription()
    {
        return 'Generate CRUD operations for backend';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['moduleName', 'langModelClass'], 'filter', 'filter' => 'trim'],
            [['moduleName', 'searchModelClass', 'moduleTitle'], 'required'],
            ['isLang', 'boolean'],
            [['moduleName', 'langModelClass'], 'string'],
        ]);
    }

    public function generate()
    {
        $controllerFile = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->controllerClass, '\\')) . '.php');

        $files = [
            new CodeFile($controllerFile, $this->render('controller.php')),
        ];

        if (!empty($this->searchModelClass)) {
            $searchModel = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->searchModelClass, '\\') . '.php'));
            $files[]     = new CodeFile($searchModel, $this->render('search.php'));
        }

        $viewPath = $this->getViewPath();
        $templatePath = $this->getTemplatePath() . '/views';

        foreach (scandir($templatePath) as $file) {
            if (is_file($templatePath . '/' . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $files[] = new CodeFile("$viewPath/$file", $this->render("views/$file"));
            }
        }

        if($this->isLang) {
            $templatePath = $this->getTemplatePath() . '/lang';
            foreach (scandir($templatePath) as $file) {
                if (is_file($templatePath . '/' . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                    $files[] = new CodeFile("$viewPath/$file", $this->render("lang/$file"));
                }
            }
        } else {
            $templatePath = $this->getTemplatePath() . '/common';
            foreach (scandir($templatePath) as $file) {
                if (is_file($templatePath . '/' . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                    $files[] = new CodeFile("$viewPath/$file", $this->render("common/$file"));
                }
            }
        }

        return $files;
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $modulePath = 'app\\modules\\' . $this->moduleName;

            if (!stripos($this->controllerClass, '\\')) {
                $this->controllerClass = $modulePath . '\\backend\\controllers\\' . $this->controllerClass;
            }

            if (!stripos($this->searchModelClass, '\\')) {
                $this->searchModelClass = $modulePath . '\\backend\\models\\' . $this->searchModelClass;
            }

            if (!stripos($this->modelClass, '\\')) {
                $this->modelClass = $modulePath . '\\common\\models\\' . $this->modelClass;
            }

            if($this->isLang && !$this->langModelClass) {
                $this->langModelClass = $this->modelClass . 'Lang';
            }

            if ($this->langModelClass && !stripos($this->langModelClass, '\\')) {
                $this->langModelClass = $modulePath . '\\common\\models\\' . $this->langModelClass;
            }

            return true;
        }
        return false;
    }

    /**
     * @return string the controller view path
     */
    public function getViewPath()
    {
        if (empty($this->viewPath)) {
            return Yii::getAlias('@app/modules/' . $this->moduleName . '/backend/views/' . $this->getControllerID());
        } else {
            return Yii::getAlias($this->viewPath);
        }
    }

    /**
     * @return array model column names
     */
    public function getLangColumnNames()
    {
        /* @var $class ActiveRecord */
        $class = $this->langModelClass;
        if (is_subclass_of($class, 'yii\db\ActiveRecord')) {
            return $class::getTableSchema()->getColumnNames();
        } else {
            /* @var $model \yii\base\Model */
            $model = new $class();

            return $model->attributes();
        }
    }

    /**
     * Generates code for active field
     * @param string $attribute
     * @return string
     */
    public function generateLangActiveField($attribute)
    {
        $tableSchema = $this->getTableSchema();
        if ($tableSchema === false || !isset($tableSchema->columns[$attribute])) {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $attribute)) {
                return "\$form->field(\$model, \"[{\$model->lang_id}]$attribute\")->passwordInput()";
            } else {
                return "\$form->field(\$model, \"[{\$model->lang_id}]$attribute\")";
            }
        }
        $column = $tableSchema->columns[$attribute];
        if ($column->phpType === 'boolean') {
            return "\$form->field(\$model, \"[{\$model->lang_id}]$attribute\")->checkbox()";
        } elseif ($column->type === 'text') {
            return "\$form->field(\$model, \"[{\$model->lang_id}]$attribute\")->textarea(['rows' => 6])";
        } else {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
                $input = 'passwordInput';
            } else {
                $input = 'textInput';
            }
            if (is_array($column->enumValues) && count($column->enumValues) > 0) {
                $dropDownOptions = [];
                foreach ($column->enumValues as $enumValue) {
                    $dropDownOptions[$enumValue] = Inflector::humanize($enumValue);
                }
                return "\$form->field(\$model, \"[{\$model->lang_id}]$attribute\")->dropDownList("
                . preg_replace("/\n\s*/", ' ', VarDumper::export($dropDownOptions)).", ['prompt' => ''])";
            } elseif ($column->phpType !== 'string' || $column->size === null) {
                return "\$form->field(\$model, \"[{\$model->lang_id}]$attribute\")->$input()";
            } else {
                return "\$form->field(\$model, \"[{\$model->lang_id}]$attribute\")->$input(['maxlength' => $column->size])";
            }
        }
    }

    public function getLangNameAttribute()
    {
        foreach ($this->getLangColumnNames() as $name) {
            if (!strcasecmp($name, 'name') || !strcasecmp($name, 'title')) {
                return $name;
            }
        }
        /* @var $class \yii\db\ActiveRecord */
        $class = $this->langModelClass;
        $pk = $class::primaryKey();

        return $pk[0];
    }


}