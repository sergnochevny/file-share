<?php

namespace backend\models\forms;

use common\models\User;
use yii\base\Model;
use Yii;
use yii\helpers\Url;

class RestorePasswordRequestForm extends Model
{
    public $identificator;

    private $user;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                ['identificator'],
                'required'
            ],
            [
                ['identificator'],
                'validateIdentificator'
            ]
        ];
    }

    public function validateIdentificator($attribute, $params){
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user) {
                $this->addError($attribute, 'Account with such username or email does not exist.');
            }
        }
    }

    /**
     * @return boolean|string
     */
    public function generateRecoveryToken()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->generatePasswordResetToken();
            if($token = $user->password_reset_token){
                $user->save();
                return $token;
            }
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'identificator' => 'Username or email',
        ];
    }

    /**
     * @return bool
     */
    public function sendRestoreLink()
    {
        if (!$this->validate()) {
            return false;
        }
        $resetToken =  $this->generateRecoveryToken();
        if (!$resetToken) {
            return false;
        }

        $user = $this->getUser();
        $template = 'passwordResetToken';
        return Yii::$app->mailer->compose([
            'html' => "$template-html",
            'text' => "$template-text",
        ], ['user' => $user])
            ->setTo([$user->email => $user->username])
            ->setFrom(['noreply@protus.com' => 'protus mail'])
            ->setSubject('Restore password')
            ->send();
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->user === null) {
            $this->user = $this->isEmail() ? User::findByEmail($this->identificator) : User::findByUsername($this->identificator);
        }
        return $this->user;
    }

    /**
     * @return mixed
     */
    protected function isEmail()
    {
        return filter_var($this->identificator, FILTER_VALIDATE_EMAIL);
    }

}