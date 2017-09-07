<?php

namespace backend\models\forms;

use backend\models\User;
use common\models\query\UndeleteableActiveQuery;
use kartik\password\StrengthValidator;
use yii\base\Model;
use yii\db\Query;
use ait\rbac\Item;

/***
 * Class UserForm
 * @package backend\models\forms
 *
 * @property-read User $user
 * @property-read string[] $adminRoles
 * @property-read string[] $customRoles
 *
 */
final class UserForm extends Model
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /** @var User */
    private $user;

    private $_customRoles;

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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['role', 'required', 'message' => 'Please choose the role of user'],
            ['role', 'in', 'range' => ['admin', 'user', 'sadmin']],
            [
                ['company_id'],
                'required',
                'when' => function ($form) {
                    //only client role require company
                    return $form->role == 'client';
                }
            ],
            [['email', 'username'], 'required'],
            [['password', 'password_repeat'], 'required', 'on' => self::SCENARIO_CREATE],
            [
                'password_repeat',
                'required',
                'enableClientValidation' => false,
                'on' => self::SCENARIO_UPDATE,
                'when' => function (UserForm $model, $attribute) {
                    return ($model->scenario === UserForm::SCENARIO_UPDATE)
                        ? !empty($model->password{0})
                        : false;
                },
            ],
            ['password', StrengthValidator::className(), 'preset' => 'fair'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
            [['company_id'], 'integer'],
            [['role', 'first_name', 'last_name', 'phone_number'], 'string'],
            [['email'], 'email'],
            [
                ['username'],
                'unique',
                'targetClass' => User::class,
                'filter' => function (UndeleteableActiveQuery $query) {
                    $query->ignoreHiddenStatuses();
                },
                'message' => 'Sorry, this username has already been taken',
                'when' => function ($model, $attribute) {
                    /** @var $model UserForm */
                    return $model->user ? $model->user->isAttributeChanged($attribute, false) : true;
                }
            ],
            [
                ['email'],
                'unique',
                'targetClass' => User::class,
                'filter' => function (UndeleteableActiveQuery $query) {
                    $query->ignoreHiddenStatuses();
                },
                'message' => 'Sorry, this email has already been taken',
                'when' => function ($model, $attribute) {
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

    /**
     * @return array
     */
    public function getAdminRoles()
    {
        return  [
            'sadmin' => 'Super admin',
            'admin' => 'Admin'
        ];
    }

    /**
     * @return array
     */
    public function getCustomRoles()
    {
        if (empty($this->_customRoles)) {
            $this->_customRoles = (new Query())->select('description')
                ->from('auth_item')
                ->indexBy('name')
                ->where(['type' => Item::TYPE_CUSTOM_ROLE])
                ->column();
        }
        return $this->_customRoles;
    }
}