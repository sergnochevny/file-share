<?php


namespace backend\models\forms;


use common\models\User;
use yii\base\Model;

final class UserForm extends Model
{
    /** @var  */
    public $role;

    /** @var string */
    public $company_id;

    /** @var string */
    public $first_name;

    /** @var string */
    public $last_name;

    /** @var string */
    public $phone_number;

    /** @var string */
    public $email;

    /** @var string */
    public $username;

    /** @var string */
    public $password;

    /** @var string */
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'email', 'username', 'password', 'password_repeat'], 'required'],
            [['company_id'], 'integer'],
            [['role', 'first_name', 'last_name', 'phone_number'], 'string'],
            [['email'], 'email'],
            [['password', 'password_repeat'], 'string', 'min' => 8],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message' => "Passwords don't match"],
            [
                ['email', 'username'],
                'unique',
                'targetClass' => User::class,
                'message' => 'Sorry, this username or email has already been taken',
            ],
        ];
    }
}