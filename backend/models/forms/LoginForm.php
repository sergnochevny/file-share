<?php

namespace backend\models\forms;

use common\models\User;
use yii\base\Model;
use Yii;
use yii\web\Cookie;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = false;

    private $user;

    public function init()
    {
        $username = Yii::$app->request->cookies->get('username');
        if ($username) {
            $this->username = $username->value;
        }
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        $isLogged = false;
        if ($this->validate()) {
            $isLogged = Yii::$app->user->login($this->getUser());
        }

        if ($isLogged) {
            if ($this->rememberMe) {
                $username = new Cookie([
                    'name' => 'username',
                    'value' => $this->getUser()->username,
                    'expire' => time() + (100 * 365 * 24 * 60 * 60)
                ]);
                Yii::$app->response->cookies->add($username);
            } else {
                Yii::$app->response->cookies->remove('username');
            }

        }

        return $isLogged;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->user === null) {
            $this->user = $this->isEmail() ? User::findByEmail($this->username) : User::findByUsername($this->username);
        }
        return $this->user;
    }

    /**
     * @return mixed
     */
    protected function isEmail()
    {
        return filter_var($this->username, FILTER_VALIDATE_EMAIL);
    }
}