<?php
namespace backend\models\forms;

use backend\models\User;
use yii\base\Model;

final class UserForm extends Model
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /** @var string */
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

    /** @var User */
    private $user;

    public function __construct(User $user, array $config = [])
    {
        $this->user = $user;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'username'], 'required'],
            [['company_id'], 'required', 'when' => function($form) {
                //only client role require company
                return $form->role == 'client';
            }],
            [['password', 'password_repeat'], 'required', 'on' => self::SCENARIO_CREATE],
            [['company_id'], 'integer'],
            [['role', 'first_name', 'last_name', 'phone_number'], 'string'],
            [['email'], 'email'],

            [['password', 'password_repeat'], 'string', 'min' => 8, 'on' => self::SCENARIO_CREATE],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message' => "Passwords don't match", 'on' => self::SCENARIO_CREATE],

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

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }
}