<?php


namespace backend\models\forms;


use yii\base\Model;

final class InvestigationForm extends Model
{
    /** @var string */
    public $company_id;

    /** @var string */
    public $title;

    /** @var string */
    public $description;

    /** @var string */
    public $start_date;

    /** @var string */
    public $end_date;

    /** @var string */
    public $contact_person;

    /** @var string */
    public $phone;

    /** @var string */
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['company_id', 'required', 'message' => 'Please choose the company'],
            [['title'], 'required'],
            [['company_id'], 'integer'],
            [['title', 'description', 'contact_person', 'phone'], 'string'],
            [['email'], 'email'],
            [['start_date', 'end_date'], 'safe'], //or change to date validator
        ];
    }
}