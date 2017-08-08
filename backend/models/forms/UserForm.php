<?php
namespace backend\models\forms;

use backend\models\User;
use common\models\query\UndeletableActiveQuery;
use kartik\password\StrengthValidator;
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


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['role', 'required', 'message' => 'Please choose the role of user'],
            ['role', 'in', 'range' => ['admin', 'user', 'superAdmin']],

            [['company_id'], 'required', 'when' => function($form) {
                //only client role require company
                return $form->role == 'user';
            }],

            [['email', 'username'], 'required'],

            [['password', 'password_repeat'], 'required', 'on' => self::SCENARIO_CREATE],

            [
                'password_repeat', 'required', 'enableClientValidation' => false,
                'when' => function(UserForm $model, $attribute) {
                    return ($model->scenario === UserForm::SCENARIO_DEFAULT)
                        ? !empty($model->password{0})
                        : false;
                },
            ],

            ['password', StrengthValidator::className(), 'preset'=>'fair'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],


            [['company_id'], 'integer'],
            [['role', 'first_name', 'last_name', 'phone_number'], 'string'],
            [['email'], 'email'],

            [
                ['username'],
                'unique',
                'targetClass' => User::class,
                'filter' => function (UndeletableActiveQuery $query) {
                    $query->ignoreHiddenStatuses();
                },
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
                'filter' => function (UndeletableActiveQuery $query) {
                    $query->ignoreHiddenStatuses();
                },
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'User Name'
        ];
    }
}