<?php
/**
 * Date: 20.03.2017
 * Time: 16:20
 */

namespace common\components;


use backend\behaviors\PermissionEvent;
use yii\base\Controller;

class PermissionController extends Controller
{

    public function verifyPermission($event, $parameters)
    {
        if ($parameters instanceof \Closure) {
            $parameters = call_user_func($parameters);
        }
        $evObj = new PermissionEvent(['parameters' => $parameters]);
        $this->trigger($event, $evObj);
        return $evObj->isTruest;
    }

}