<?php


namespace backend\models\forms;


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
        ];
    }

}