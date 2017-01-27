<?php


namespace backend\models\forms;


use common\models\Company;
use yii\base\Model;

final class CompanyForm extends Model
{
    /** @var string */
    public $name;

    /** @var string */
    public $address;

    /** @var  string */
    public $city;

    /** @var string */
    public $state;

    /** @var string */
    public $zip;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'address', 'city', 'state'], 'string', 'max' => 255],
            [['zip'], 'string', 'max' => 10],
            [
                ['name'],
                'unique',
                'targetClass' => Company::class,
                'message' => 'Sorry, the company with the same name has already been created',
            ],
        ];
    }

}