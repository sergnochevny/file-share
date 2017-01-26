<?php


namespace backend\models\services;


use backend\models\Company;
use backend\models\forms\UserForm;
use backend\models\User;
use yii\base\Exception;
use yii\rbac\DbManager;


/**
 * Class UserService
 * @package backend\models
 */
final class UserService
{
    /** @var User  */
    private $user;

    /** @var DbManager  */
    private $authManager;

    /**
     * UserService constructor.
     * @param User $user
     * @param DbManager $auth
     */
    public function __construct(User $user, DbManager $auth)
    {
        $this->user = $user;
        $this->authManager = $auth;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param UserForm $form
     * @return bool
     * @throws Exception
     */
    public function save(UserForm $form)
    {
        $user = $this->user;
        if ($user->isNewRecord) {
            $user->generateAuthKey();
            $user->setPassword($form->password);
        }

        $user->setAttributes($form->getAttributes([
            'first_name',
            'last_name',
            'phone_number',
            'email',
            'username',
        ]));

        if ($user->save() && $this->assignRole($form->role)) {
            //drop old relations if company related
            $user->unlinkAll('companies', true);

            if ($form->company_id) {
                $company = $this->getCompany($form->company_id);
                $company->link('users', $user);
            }

            return true;
        }

        return false;
    }

    /**
     * @param $id
     * @return Company
     * @throws
     */
    private function getCompany($id)
    {
        $company = Company::findOne($id);
        if (!$company) {
            throw new Exception("The company doesn't exists");
        }

        return $company;
    }

    /**
     * @param $role
     * @return \yii\rbac\Assignment | bool
     * @throws Exception
     */
    private function assignRole($role)
    {
        $auth = $this->authManager;
        $user = $this->user;

        if (!$user->id) {
            throw new Exception("The user doesn't exists");
        }
        $role = $auth->getRole($role);
        if (null === $role) {
            throw new Exception("Such role doesn't exists");
        }
        //reset role in case of update
        $auth->revokeAll($user->id);

        return $auth->assign($role, $user->id);
    }
}