<?php
/**
 * Date: 02.02.2017
 * Time: 17:27
 */

namespace backend\behaviors;

use common\models\UndeleteableActiveRecord;
use common\models\User;
use exceptions\PermissionDeniedException;
use Yii;
use yii\base\Behavior;
use yii\base\Model;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;

/**
 * Class VerifyPermissionBehavior
 * @package backend\behaviors
 */
class VerifyPermissionBehavior extends Behavior
{
    /**
     *
     */
    const EVENT_VERIFY_FILE_PERMISSION = 'verifyFilePermission';
    const EVENT_VERIFY_FILE_DOWNLOAD_PERMISSION = 'verifyFileDownloadPermission';

    /**
     * @var array
     */
    public $actions = [];

    public $permissionNames;

    /**
     * Checks if user can perform some action
     * If he is owner of the record or permission granted to him directly
     *
     * @return bool TRUE if user can, else the Exception will be thrown
     * @throws PermissionDeniedException
     */
    protected function checkPermission()
    {
        if ($this->isUserOwnerOfRecord()
            || Yii::$app->user->can($this->getPermissionName())) {
            return true;
        }

        throw new PermissionDeniedException('You can\'t perform this action');
    }

    /**
     * Creates something like site.index.all (controller.action.all)
     * or if it has module - module.controller.action.all
     *
     * @return string
     */
    protected function getPermissionName()
    {
        return str_replace('/', '.', Yii::$app->controller->action->uniqueId) . '.all';
    }

    /**
     * Checks if current user is owner of the record
     *
     * @return bool
     * @throws PermissionDeniedException Will be thrown if user not logged
     */
    protected function isUserOwnerOfRecord()
    {
        /** @var User|null $identity */
        $identity = Yii::$app->user->identity;
        if ($identity === null) {
            throw new PermissionDeniedException('You can\'t perform this action');
        }

        $model = $this->owner;
        if (!empty($model->created_by)) {
            return $model->created_by === $identity->id;
        }

        return false;
    }

    /**
     * @return array
     */
    public function events()
    {
        return [
            self::EVENT_VERIFY_FILE_PERMISSION => 'verifyFilePermission',
            self::EVENT_VERIFY_FILE_DOWNLOAD_PERMISSION => 'verifyFileDownloadPermission',
            Model::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
            UndeleteableActiveRecord::EVENT_BEFORE_ARCHIVE => 'beforeArchive'
        ];
    }

    /**
     * @param PermissionEvent $event
     * @return bool|mixed
     */
    public function verifyFilePermission(PermissionEvent $event)
    {
        $prms = $event->parameters;

        $event->isTruest = (
            Yii::$app->user->can('sadmin') || Yii::$app->user->can('admin') ||
            (
                !Yii::$app->user->can('sadmin') && !Yii::$app->user->can('admin') ||
                Yii::$app->user->can('employee', $prms)
            )
        );

        return $event->isTruest;
    }

    /**
     * @param PermissionEvent $event
     * @return bool|mixed
     */
    public function verifyFileDownloadPermission(PermissionEvent $event)
    {
        $parameters = $event->parameters;
        $investigation = $parameters['investigation'];
        $model = $parameters['model'];

        $event->isTruest = (
            Yii::$app->user->can('admin') || Yii::$app->user->can('sadmin') ||
            (
                !Yii::$app->user->can('admin') && !Yii::$app->user->can('sadmin') &&
                (
                    (
                        !empty($investigation) &&
                        Yii::$app->user->can('employee', ['investigation' => $investigation])
                    ) ||
                    (Yii::$app->user->can('employee', ['allfiles' => $model->parents->parent]))
                )
            )
        );

        return $event->isTruest;
    }

    /**
     * @param ModelEvent $event
     * @return bool
     */
    public function beforeInsert(ModelEvent $event)
    {
        return $event->isValid = true;
    }

    /**
     * @param ModelEvent $event
     * @return bool
     */
    public function beforeUpdate(ModelEvent $event)
    {
        return $event->isValid = $this->checkPermission();
    }

    /**
     * @param ModelEvent $event
     * @return bool
     */
    public function beforeDelete(ModelEvent $event)
    {
        return $event->isValid = $this->checkPermission();
    }

    /**
     * @param ModelEvent $event
     * @return bool
     */
    public function beforeArchive(ModelEvent $event)
    {
        return $event->isValid = $this->checkPermission();
    }

}
