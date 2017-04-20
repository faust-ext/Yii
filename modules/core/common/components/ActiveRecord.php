<?php

namespace app\modules\core\common\components;

use yii\validators\DefaultValueValidator;

class ActiveRecord extends \yii\db\ActiveRecord
{
    public function initDefaultValues()
    {
        foreach($this->getValidators() as $validator) {
            if($validator instanceof DefaultValueValidator) {
                $validator->validateAttributes($this, $validator->attributes);
            }
        }

    }
}