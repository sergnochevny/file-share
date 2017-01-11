<?php


namespace backend\models;


class Investigation extends \common\models\Investigation
{
    /**
     * @return array
     */
    public function getStatusLabels()
    {
        $labels = parent::getStatusLabels();
        array_shift($labels);
        return $labels;
    }
}