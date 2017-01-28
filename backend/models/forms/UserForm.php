<?php


namespace backend\models\forms;


use backend\models\User;
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

    /** @var  User */
    private $user;

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
                ['username'],
                'unique',
                'targetClass' => User::class,
                'message' => 'Sorry, this username has already been taken',
                'when' => function($model, $attribute) {
                    /** @var $model UserForm */
                    return $model->user ? $model->user->isAttributeChanged($attribute, false) : true;
                }
            ],
            [
                ['email'],
                'unique',
                'targetClass' => User::class,
                'message' => 'Sorry, this email has already been taken',
                'when' => function($model, $attribute) {
                    /** @var $model UserForm */
                    return $model->user ? $model->user->isAttributeChanged($attribute, false) : true;

                }
            ],
        ];
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }
}