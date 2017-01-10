<?php


namespace backend\models;


use common\models\User;
use yii\base\Model;
use yii\web\JsExpression;

/**
 * Class UserForm
 * @package backend\models
 *
 * @property User $user
 */
class UserForm extends Model
{
    const SCENARIO_CREATE = 'create';
    //const SCENARIO_UPDATE = 'update';

    public $firstName;
    public $lastName;
    public $phoneNumber;
    public $email;
    public $username;

    public $password;
    public $passwordRepeat;

    private $user;

    public function __construct(User $user, array $config = [])
    {
        $this->user = $user;
        parent::__construct($config);
    }

    public function init()
    {
        if (!$this->isNewRecord()) {
            $user = $this->user;
            $this->firstName = $user->first_name;
            $this->lastName = $user->last_name;
            $this->phoneNumber = $user->phone_number;
            $this->email = $user->email;
            $this->username = $user->username;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['email', 'username', 'password', 'passwordRepeat'], 'required',
                'on' => self::SCENARIO_CREATE
            ],
            [['firstName', 'lastName', 'phoneNumber'], 'string'],
            [['password', 'passwordRepeat'], 'string', 'min' => 6],

//            ['passwordRepeat', 'required', 'when' => function($model) {
//                if (!empty($model->password)) {
//                    return !$model->getUser()->validatePassword($model->password);
//                }
//
//                return false;
//            }, 'enableClientValidation' => false],
            [
                'passwordRepeat', 'compare',
                'compareAttribute'=>'password', 'message'=>"Passwords don't match"
            ],

            [
                ['email', 'username'],
                'unique',
                'targetClass' => User::class,
                'message' => 'Sorry, this username or email has already been taken',
                'on' => self::SCENARIO_CREATE
            ],
            ['email', 'email', 'on' => self::SCENARIO_CREATE]
        ];
    }

    /**
     * Saves user form to user model
     *
     * @return User|null
     */
    public function saveUser()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = $this->user;
        if ($this->isNewRecord()) {
            $user->generateAuthKey();
            $user->username = $this->username;
            $user->email = $this->email;
        }
        //in case of update record
        if ($this->password) {
            $user->setPassword($this->password);
        }

        $user->first_name = $this->firstName;
        $user->last_name = $this->lastName;
        $user->phone_number = $this->phoneNumber;

        return $user->save(false) ? $user : null;
    }

    /**
     * @return bool
     */
    public function isNewRecord()
    {
        return $this->user->isNewRecord;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}