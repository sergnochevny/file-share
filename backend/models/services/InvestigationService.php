<?php


namespace backend\models\services;


use backend\models\forms\InvestigationForm;
use backend\models\Investigation;

final class InvestigationService
{
    private $investigation;

    public function __construct(Investigation $investigation)
    {
        $this->investigation = $investigation;
    }

    /**
     * @param InvestigationForm $form
     * @return bool
     */
    public function save(InvestigationForm $form)
    {
        $this->investigation->setAttributes($form->getAttributes(null, ['start_date', 'end_date']));
        $this->setDate('start_date', $form->start_date);
        $this->setDate('end_date', $form->end_date);

        return $this->investigation->save();
    }

    /**
     * Sets date to attribute
     *
     * @param string $attribute
     * @param string $date
     */
    private function setDate($attribute, $date)
    {
        if (!empty($date)) {
            $date = new \DateTime($date);
            $this->investigation->$attribute = $date->format('Y-m-d');
        }
    }

}