<?php

namespace common\widgets;

use yii\helpers\Html;

class BootstrapAlert extends \yii\bootstrap\Alert
{

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo "\n" . $this->renderBodyEnd();
        echo "\n" . Html::endTag('div');

//        $this->registerPlugin('alert');
    }

}