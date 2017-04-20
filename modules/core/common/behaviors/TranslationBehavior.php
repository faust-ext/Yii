<?php

namespace app\modules\core\common\behaviors;

use app\modules\core\common\models\Lang;
use app\modules\core\common\models\Status;
use yii\base\Behavior;
use yii\base\Exception;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class TranslationBehavior extends Behavior
{
    public $langModel;
    public $langModelAttribute;

    private $_translations;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'validateTranslations',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'validateTranslations',
            ActiveRecord::EVENT_AFTER_INSERT => 'saveTranslations',
            ActiveRecord::EVENT_AFTER_UPDATE => 'saveTranslations'
        ];
    }

    public function initTranslations()
    {
        $model = $this->langModel;

        $this->_translations = [];

        $langs = Lang::find()->all();
        if ($this->owner->isNewRecord) {
            foreach ($langs as $lang) {
                $this->_translations[$lang->id] = new $model;
                $this->_translations[$lang->id]->lang_id = $lang->id;
            }
        } else {
            $this->_translations = $model::find()->where([$this->langModelAttribute => $this->owner->id])->indexBy('lang_id')->all();
            foreach ($langs as $lang) {
                if (!isset($this->_translations[$lang->id])) {
                    $this->_translations[$lang->id] = new $model;
                    $this->_translations[$lang->id]->lang_id = $lang->id;
                }
            }
        }
    }

    public function getTranslations()
    {
        if ($this->_translations === null) {
            $this->initTranslations();
        }

        return $this->_translations;
    }

    public function saveTranslations($event)
    {
        try {
            foreach ($this->_translations as $model) {
                if ($event->name = 'afterInsert') {
                    $model->{$this->langModelAttribute} = $this->owner->id;
                }
                $model->save(false);
            }
            \Yii::$app->db->transaction->commit();
        } catch (Exception $e) {
            \Yii::$app->db->transaction->rollBack();
            \Yii::$app->session->setFlash('error', 'При попытке сохранения переводов произошла ошибка! Попробуйте еще раз!');
        }

    }

    public function validateTranslations($event)
    {

        if ($event->isValid) {
            if ($this->_translations === null) {
                $this->initTranslations();
            }

            if (!(Model::loadMultiple($this->_translations,
                    \Yii::$app->request->post()) && Model::validateMultiple($this->_translations))
            ) {
                $event->isValid = false;
            }
        }

        if ($event->isValid) {
            \Yii::$app->db->beginTransaction();
        }
    }

}