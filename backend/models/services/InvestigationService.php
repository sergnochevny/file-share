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

    public function save(InvestigationForm $form)
    {
        $this->investigation->setAttributes($form->getAttributes());
        return $this->investigation->save();
    }
}