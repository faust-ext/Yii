<?php

namespace app\modules\core\backend\components;

use yii;
use yii\helpers\Html;

class ActionColumn extends \yii\grid\ActionColumn
{
    protected function initDefaultButtons()
    {
        parent::initDefaultButtons();
        if (!isset($this->buttons['publish'])) {
            $this->buttons['publish'] = function ($url, $model) {
                if (isset($model->is_active)) {
                    if ($model->is_active) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title'       => Yii::t('yii', 'Снять с публикации'),
                            'data-method' => 'post',
                            'data-pjax'   => '0',
                        ]);
                    } else {
                        return Html::a('<span class="glyphicon glyphicon-eye-close"></span>', $url, [
                            'title'       => Yii::t('yii', 'Опубликовать'),
                            'data-method' => 'post',
                            'data-pjax'   => '0',
                        ]);
                    }
                }
            };
        }
        if (!isset($this->buttons['erase'])) {
            $this->buttons['erase'] = function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-remove-circle"></span>', $url, [
                    'title'        => Yii::t('yii', 'Удалить'),
                    'data-confirm' => Yii::t('yii', 'Вы уверены, что хотите удалить этот элемент?'),
                    'data-method'  => 'post',
                    'data-pjax'    => '0',
                ]);
            };
        }
        if (!isset($this->buttons['restore'])) {
            $this->buttons['restore'] = function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-repeat"></span>', $url, [
                    'title'       => Yii::t('yii', 'Восстановить'),
                    'data-method' => 'post',
                    'data-pjax'   => '0',
                ]);
            };
        }
    }
}