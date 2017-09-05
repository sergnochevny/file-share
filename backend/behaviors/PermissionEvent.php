<?php
/**
 * Date: 20.03.2017
 * Time: 16:08
 */

namespace backend\behaviors;

use yii\base\Event;

class PermissionEvent extends Event
{
    public $parameters;

    public $isTruest = true;
}