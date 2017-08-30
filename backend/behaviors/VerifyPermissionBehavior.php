<?php
/**
 * Date: 02.02.2017
 * Time: 17:27
 */

namespace backend\behaviors;

use common\models\UndeleteableActiveRecord;
use common\models\User;
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

        $event->isTruest = (Yii::$app->user->can('sadmin') || Yii::$app->user->can('admin') ||
            (!Yii::$app->user->can('sadmin') && !Yii::$app->user->can('admin') ||
                Yii::$app->user->can('employee', $prms)));

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

        $event->isTruest = (Yii::$app->user->can('admin') || Yii::$app->user->can('sadmin') ||
            (
                !Yii::$app->user->can('admin') && !Yii::$app->user->can('sadmin') &&
                ((!empty($investigation) && Yii::$app->user->can('employee', ['investigation' => $investigation])) ||
                    (Yii::$app->user->can('employee', ['allfiles' => $model->parents->parent])))
            )
        );

        return $event->isTruest;
    }

    public function beforeInsert(ModelEvent $event){
        return $event->isValid = true;
    }

    public function beforeUpdate(ModelEvent $event){

//        /** @var User|null $identity */
//        $identity = Yii::$app->user->identity;
//        if ($identity === null) {
//            //or throw error
//            return false;
//        }
//        if ($this->isUserOwnerOfRecord($identity)) {
//            //is can
//            return true;
//        }
//
//        if (!empty($this->permissionNames[$event->name])
//            && Yii::$app->user->can($this->permissionNames[$event->name])) {
//
//            //is can
//            return true;
//        }
//
//        return false;
//        //return $event->isValid = true;
    }

    public function beforeDelete(ModelEvent $event){
        return $event->isValid = true;
    }

    public function beforeArchive(ModelEvent $event){
        return $event->isValid = true;
    }

    protected function isUserOwnerOfRecord(User $user) {
        $model = $this->owner;
        if (!empty($model->created_by)) {
            return $model->created_by === $user->id;
        }

        return false;
    }

}
