<?php


namespace backend\models\forms;


use common\models\User;
use yii\base\Model;

class UserForm extends Model
{
    /** @var string */
    public $firstName;

    /** @var string */
    public $lastName;

    /** @var string */
    public $phoneNumber;

    /** @var string */
    public $email;

    /** @var string */
    public $username;

    /** @var string */
    public $password;

    /** @var string */
    public $passwordRepeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'username', 'password', 'passwordRepeat'], 'required'],
            [['firstName', 'lastName', 'phoneNumber'], 'string'],
            [['password', 'passwordRepeat'], 'string', 'min' => 8],
            ['passwordRepeat', 'compare', 'compareAttribute'=>'password', 'message' => "Passwords don't match"],
            [
                ['email', 'username'],
                'unique',
                'targetClass' => User::class,
                'message' => 'Sorry, this username or email has already been taken',
            ],
        ];
    }
}