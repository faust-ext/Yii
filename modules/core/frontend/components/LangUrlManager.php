<?php
namespace app\modules\core\frontend\components;

use app\modules\core\common\models\Lang;
use Yii;
use \yii\web\UrlManager;

class LangUrlManager extends UrlManager
{
    private $_items;

    public function init()
    {
        parent::init();
    }

    public function createUrl($params)
    {
        if (isset($params['lang_id']))
        {
            //Если указан идентификатор языка, то делаем попытку найти язык в БД,
            //иначе работаем с языком по умолчанию
            $lang = Lang::findOne($params['lang_id']);
            if ($lang === null)
            {
                $lang = Lang::getDefaultLang();
            }
            unset($params['lang_id']);
        }
        else
        {
            //Если не указан параметр языка, то работаем с текущим языком
            $lang = Lang::getCurrent();
        }

        //Получаем сформированный URL(без префикса идентификатора языка)
        $url = parent::createUrl($params);

        //Добавляем к URL префикс - буквенный идентификатор языка
        return preg_replace('|\%2F|i', '/', $lang->getLangPrefix() . $url);
    }
}