<?php

namespace app\modules\core\common\behaviors;

use app\modules\core\common\models\Status;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class SoftDeleteBehavior extends Behavior
{
    // Событие после полного удаления объекта
    const EVENT_AFTER_ERASE = 'erase';
    const EVENT_BEFORE_REMOVE = 'beforeRemove';

    /**
     * @var string status attribute
     */
    public $attribute = 'status';

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_DELETE => 'remove',
        ];
    }

    public function remove($event)
    {
        $this->owner->trigger(self::EVENT_BEFORE_REMOVE, $event);

        if($event->isValid) {
            $this->owner->updateAttributes([$this->attribute => Status::DELETED]);
            $event->isValid = false;
        }
    }

    public function restore()
    {
        if($this->owner->{$this->attribute} == Status::DELETED) {
            $this->owner->updateAttributes([$this->attribute => Status::ACTIVE]);
        } else {
            \Yii::$app->session->setFlash('error', 'Для восстановления элемент должен быть в корзине.');
        }
    }

    public function erase()
    {
        if($this->owner->{$this->attribute} == Status::DELETED) {
            $this->owner->updateAttributes([$this->attribute => Status::ERASED]);
            $this->owner->trigger(self::EVENT_AFTER_ERASE);
        } else {
            \Yii::$app->session->setFlash('error', 'Для полного удаления элемент должен быть в корзине.');
        }
    }

    public function forceDelete($event)
    {
        // Need to test
        $this->owner->trigger(self::EVENT_BEFORE_REMOVE, $event);
        if($event->isValid) {
            $this->owner->trigger(self::EVENT_AFTER_ERASE);
            $model = $this->owner;
            $this->detach();
            $model->delete();
        }
    }

}