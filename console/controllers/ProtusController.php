<?php


namespace console\controllers;


use backend\components\rbac\rules\EmployeeRule;
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
     * Initiate site. Creates roles client and admin. Creates admin account
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
        $this->createAdminAccount($username, $email, $password);
    }

    /**
     * @return bool|int
     */
    private function initRoles()
    {
        $manager = \Yii::$app->getAuthManager();
        $manager->removeAll();

        $client = $manager->createRole('client');
        $admin = $manager->createRole('admin');
        $manager->add($client);
        $manager->add($admin);
        //add all client permissions to admin
        $manager->addChild($admin, $client);

        $rule = new EmployeeRule();
        $manager->add($rule);

        $employee = $manager->createPermission('employee');
        $employee->description = 'Employee';
        $employee->ruleName = $rule->name;
        $manager->add($employee);

        $manager->addChild($client, $employee);
        $this->stdout('OK' . "\n");
    }


    private function createAdminAccount($username, $email, $password)
    {
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();
        if (!$user->save()) {
            return $this->stdout("Admin user was not created" . PHP_EOL, Console::FG_RED);
        }

        $manager = \Yii::$app->getAuthManager();
        $admin = $manager->getRole('admin');
        $manager->assign($admin, $user->id);

        return $this->stdout('Admin user was successfully created' . PHP_EOL, Console::FG_GREEN);
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