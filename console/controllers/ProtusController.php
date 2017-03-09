<?php


namespace console\controllers;


use backend\components\rbac\rules\EmployeeRule;
use Citrix\ShareFile\Api\Models\Query;
use common\models\User;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class ProtusController
 * @package console\controllers
 */
class ProtusController extends Controller
{

    /**
     * Initiate site. Creates roles client, admin and super admin. Creates super admin account. WARNING! If you already have db with roles, this will overwrite it. To add role or user see add-role, create-user respectively
     *
     * @param string $adminData username:email:password[Minimum 8 digits]
     * @return string
     */
    public function actionInit($adminData)
    {
        list($username, $email, $password) = explode(":", $adminData);

        if ($this->hasErrors($username, $password)) {
            return;
        }

        $this->initRoles();
        return $this->createSuperAdminAccount($username, $email, $password);
    }

    /**
     * Adds role to DB. If set child new role will get this child
     *
     * @param string $name Name of new role
     * @param bool|string $child Name of child (optional)
     * @return bool|int
     */
    public function actionAddRole($name, $child = false)
    {
        $manager = \Yii::$app->getAuthManager();
        //ensure that user want overwrite roles
        if ($manager->getRole($name)) {
            return $this->stderr('Role already exists' . PHP_EOL, Console::FG_RED);
        }

        $newRole = $manager->createRole($name);
        $manager->add($newRole);
        if ($child) {
            $child = $manager->getRole($child);
            $manager->addChild($newRole, $child);
        }

        return $this->stdout('Role added' . PHP_EOL, Console::FG_GREEN);
    }

    /**
     * Creates user and assigns a role. Usage: protus/create-user username:email:password:role
     *
     * @param $userData
     * @return bool|int
     */
    public function actionCreateUser($userData)
    {
        list($username, $email, $password, $role) = explode(":", $userData);
        $manager = \Yii::$app->getAuthManager();
        $role = $manager->getRole($role);
        if ($role === null) {
            return $this->stderr('This role does not exists' . PHP_EOL, Console::FG_RED);
        }

        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();
        if (!$user->save()) {
            return $this->stdout('User ' . $user->username . ' was not created' . PHP_EOL, Console::FG_RED);
        }
        $manager->assign($role, $user->id);

        return $this->stdout('User ' . $user->username . ' was successfully created with role ' . $role->name . PHP_EOL, Console::FG_GREEN);
    }

    /**
     * Remove user from db. Warning! This is DELETE FROM query and not just change status to DELETE
     * @param string $username
     * @return string
     */
    public function actionRemoveUser($username)
    {
        $user = User::findOne(['username' => $username]);
        if ($user) {
            $manager = \Yii::$app->getAuthManager();
            $manager->revokeAll($user->id);
            $rows = \Yii::$app->getDb()->createCommand("DELETE FROM `user` WHERE `id` = {$user->id}")->execute();
            if ($rows > 0) {
                return $this->stdout('User was removed' . PHP_EOL, Console::FG_GREEN);
            } else {
                return $this->stdout('Nothing to remove' . PHP_EOL, Console::FG_GREEN);
            }
        }

        return $this->stdout('User not found' . PHP_EOL, Console::FG_RED);
    }

    /**
     * @return bool|int
     */
    private function initRoles()
    {
        $manager = \Yii::$app->getAuthManager();
        //ensure that user want overwrite roles
        if ($manager->getRole('client')) {
            $answer = $this->prompt('You already have some roles. Do you want overwrite it? y/yes:', ['required' => true]);
            if (in_array(strtolower($answer), ['y', 'yes'])) {
                $this->stdout('OK. Now will be overwrite all' . PHP_EOL, Console::FG_GREEN);
                $manager->removeAll();
            } else {
                $this->stdout('OK. Nothing was touched' . PHP_EOL, Console::FG_GREEN);
                \Yii::$app->end();
            }
        }

        $client = $manager->createRole('client');
        $admin = $manager->createRole('admin');
        $superAdmin = $manager->createRole('superAdmin');
        $manager->add($client);
        $manager->add($admin);
        $manager->add($superAdmin);
        //add all client permissions to admin
        $manager->addChild($admin, $client);
        //add all admin permissions to superadmin
        $manager->addChild($superAdmin, $admin);

        $rule = new EmployeeRule();
        $manager->add($rule);

        $employee = $manager->createPermission('employee');
        $employee->description = 'Employee';
        $employee->ruleName = $rule->name;
        $manager->add($employee);

        $manager->addChild($client, $employee);
        return $this->stdout('OK' . "\n");
    }

    private function createSuperAdminAccount($username, $email, $password)
    {
        return $this->actionCreateUser("$username:$email:$password:superAdmin");
    }

    /**
     * Checks for username exists and password has at least 8 digits
     *
     * @param $username
     * @param $password
     * @return bool
     */
    private function hasErrors($username, $password)
    {
        $errors = false;
        $user = User::findOne(['username' => $username]);
        if ($user) {
            $errors = true;
            $this->stderr('User already exists' . PHP_EOL, Console::FG_RED);
        }

        if (mb_strlen($password) < 8) {
            $errors = true;
            $this->stderr('Password must be at least 8 digits length' . PHP_EOL, Console::FG_RED);
        }

        return $errors;
    }
}