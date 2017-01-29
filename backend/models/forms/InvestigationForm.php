<?php


namespace backend\models\forms;

use common\models\Company;
use common\models\Investigation;
use yii\base\Model;

final class InvestigationForm extends Model
{
    /** @var string */
    public $company_id;

    /** @var string */
    public $name;

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
            [['name'], 'required'],
            [['company_id'], 'integer'],
            [['name', 'contact_person', 'phone'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 2000],
            [['email'], 'email'],
            [['start_date', 'end_date'], 'safe'], //or change to date validator
            [
                ['company_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Company::class,
                'targetAttribute' => ['company_id' => 'id']
            ],
            [
                ['name'],
                'unique',
                'targetClass' => Investigation::class,
                'message' => 'Sorry, the applicant with the same name has already been created',
            ],
        ];
    }

}