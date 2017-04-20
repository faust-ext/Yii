<?php
/**
 * Created by PhpStorm.
 * User: helena
 * Date: 29.04.15
 * Time: 13:19
 */
namespace app\modules\core\common\components;

interface MenuInterface
{
    public function getControllers();

    public function getTitle();

}