<?php
namespace app\modules\core\frontend\components;

use app\modules\core\common\models\Lang;
use Yii;
use yii\web\Request;

class LangRequest extends Request
{
    protected function resolveRequestUri()
    {
        $requestUri = parent::resolveRequestUri();
        $requestUriToList = explode('/', $requestUri);
        $lang_url = isset($requestUriToList[1]) ? $requestUriToList[1] : null;

        Lang::setCurrent($lang_url);

        if( $lang_url !== null && $lang_url === Lang::getCurrent()->prefix && strpos($requestUri, Lang::getCurrent()->prefix) === 1 )
        {
            $requestUri = substr($requestUri, strlen(Lang::getCurrent()->prefix)+1 );
        }

        return $requestUri;
    }

}