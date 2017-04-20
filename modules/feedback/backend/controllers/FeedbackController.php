<?php

namespace app\modules\feedback\backend\controllers;

use app\modules\core\backend\components\ARController;
use Yii;
use app\modules\feedback\common\models\Feedback;
use app\modules\feedback\backend\models\FeedbackSearch;

/**
 * FeedbackController implements the CRUD actions for Feedback model.
 */
class FeedbackController extends ARController
{
    protected function getModelClass()
    {
        return Feedback::className();
    }

    protected function getSearchModelClass()
    {
        return FeedbackSearch::className();
    }
}
