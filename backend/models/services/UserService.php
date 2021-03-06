<?php


namespace backend\models\services;

use backend\behaviors\NotifyBehavior;
use backend\models\forms\UserForm;
use backend\models\User;
use common\models\Company;
use common\models\UndeleteableActiveRecord;
use yii\base\Component;
use yii\base\Event;
use yii\base\Exception;
use yii\base\ModelEvent;
use yii\rbac\DbManager;


/**
 * Class UserService
 * @package backend\models
 */
final class UserService extends Component
{
    /** @var User */
    private $user;

    /**
     * UserService constructor.
     * @param User $user
     * @param DbManager $auth
     * @param array $config
     */
    public function __construct(User $user, array $config = [])
    {
        $this->user = $user;
        parent::__construct($config);
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
        $auth = \Yii::$app->authManager;
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

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function behaviors()
    {
        return [
            [
                'class' => NotifyBehavior::class,
                'sendFrom' => function () {
                    return \Yii::$app->keyStorage->get('system.sendfrom');
                },
                'companyId' => function (UserService $model) {
                    return $model->user->company ? $model->user->company->id : null;
                },
                'createTemplate' => 'create',
                'updateTemplate' => 'update',
                'archiveTemplate' => 'archive',
                'deleteTemplate' => 'delete',
            ],
        ];
    }

    /**
     * @param UserForm $form
     */
    public function populateForm(UserForm $form)
    {
        $user = $this->user;
        $form->setUser($this->user);
        $form->setAttributes($user->getAttributes());

        //admin can't have company
        $form->company_id = isset($user->company->id) ? $user->company->id : null;
        $form->role = $user->getUserRole();
    }

    /**
     * @param UserForm $form
     * @return bool
     * @throws Exception
     */
    public function save(UserForm $form)
    {
        if (!$this->afterValidate()) {
            return false;
        }

        $user = $this->user;
        $form->setUser($user);
        $isInsert = false;
        if ($user->isNewRecord) {
            $isInsert = true;
            $user->generateAuthKey();
            $user->setPassword($form->password);

        } elseif (!empty($form->password{0})) {
            $user->setPassword($form->password);
        }

        $user->setAttributes($form->getAttributes([
            'first_name',
            'last_name',
            'phone_number',
            'email',
            'username',
        ]));

        if ($this->beforeSave($isInsert) && $user->save() && $this->assignRole($form->role)) {
            //drop old relations if company related
            $user->unlinkAll('company', true);

            if ($form->company_id) {
                $company = $this->getCompany($form->company_id);
                $company->link('users', $user);
            }

            $this->afterSave($isInsert);
            return true;
        }

        return false;
    }

    /**
     * @return void
     */
    public function delete()
    {
        $this->user->delete();
        $this->trigger(UndeleteableActiveRecord::EVENT_AFTER_DELETE, new Event());
    }

    /**
     * @return void
     */
    public function archive()
    {
        $this->user->archive();
        $this->trigger(UndeleteableActiveRecord::EVENT_AFTER_ARCHIVE, new Event());
    }

    /**
     * @return bool
     */
    public function afterValidate()
    {
        $event = new ModelEvent;
        $this->trigger(UndeleteableActiveRecord::EVENT_AFTER_VALIDATE, $event);

        return $event->isValid;
    }

    /**
     * @param $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $event = new ModelEvent;
        $this->trigger(
            $insert ? UndeleteableActiveRecord::EVENT_BEFORE_INSERT : UndeleteableActiveRecord::EVENT_BEFORE_UPDATE,
            $event
        );

        return $event->isValid;
    }

    /**
     * @param bool $insert
     * @return void
     */
    public function afterSave($insert)
    {
        $this->trigger(
            $insert ? UndeleteableActiveRecord::EVENT_AFTER_INSERT : UndeleteableActiveRecord::EVENT_AFTER_UPDATE,
            new Event()
        );
    }
}