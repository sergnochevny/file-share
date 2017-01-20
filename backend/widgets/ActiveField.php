<?php


namespace backend\widgets;


/**
 * Class ActiveField
 * @package backend\widgets
 */
class ActiveField extends \yii\widgets\ActiveField
{
    public $template = "{label}\n<div class=\"col-sm-8\">{input}</div>\n{hint}\n{error}";
    public $labelOptions = ['class' => 'col-sm-4 control-label'];
    public $errorOptions = ['class' => 'col-sm-8 col-sm-offset-4 help-block'];
}