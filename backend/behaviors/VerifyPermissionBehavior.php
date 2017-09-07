<?php
/**
 * Date: 02.02.2017
 * Time: 17:27
 */

namespace backend\behaviors;

use ait\auth\behaviors\ModelPermissionsBehavior;
use backend\models\Investigation;
use backend\models\User;
use common\models\UndeleteableActiveRecord;
use Yii;
use yii\base\ModelEvent;

/**
 * Class VerifyPermissionBehavior
 * @package backend\behaviors
 */
class VerifyPermissionBehavior extends ModelPermissionsBehavior
{
    /**
     *
     */
    const EVENT_VERIFY_FILE_UPLOAD_PERMISSION = 'verifyFileUploadPermission';
    const EVENT_VERIFY_FILE_MUPLOAD_PERMISSION = 'verifyFileMUploadPermission';
    const EVENT_VERIFY_FILE_ARCHIVE_PERMISSION = 'verifyFileArchivePermission';
    const EVENT_VERIFY_FILE_DOWNLOAD_PERMISSION = 'verifyFileDownloadPermission';
    const EVENT_VERIFY_FILE_MDOWNLOAD_PERMISSION = 'verifyFileMDownloadPermission';

    /**
     * @var array
     */
    public $actions = [];



    /**
     * @return array
     */
    public function events()
    {
        $events = parent::events();
        return array_merge($events, [
            self::EVENT_VERIFY_FILE_UPLOAD_PERMISSION => 'verifyFileUploadPermission',
            self::EVENT_VERIFY_FILE_MUPLOAD_PERMISSION => 'verifyFileMUploadPermission',
            self::EVENT_VERIFY_FILE_ARCHIVE_PERMISSION => 'verifyFileArchivePermission',
            self::EVENT_VERIFY_FILE_DOWNLOAD_PERMISSION => 'verifyFileDownloadPermission',
            self::EVENT_VERIFY_FILE_MDOWNLOAD_PERMISSION => 'verifyFileMDownloadPermission',
            UndeleteableActiveRecord::EVENT_BEFORE_ARCHIVE => 'beforeArchive'
        ]);
    }

    /**
     * @param PermissionEvent $event
     * @return bool|mixed
     */
    public function verifyFileUploadPermission(PermissionEvent $event)
    {

        $parameters = $event->parameters;
        $investigation = $parameters['investigation'];
        $model = $parameters['model'];

        $event->isTruest = static::canUpload($investigation, $model);

        return $event->isTruest;
    }

    /**
     * @param $investigation
     * @param $model
     * @return bool
     */
    public static function canUpload($investigation, $model)
    {
        return Yii::$app->user->can('file.upload.all') ||
            (
                Yii::$app->user->can('file.upload') &&
                (
                    (!empty($investigation) && Yii::$app->user->can('employee', ['investigation' => $investigation])) ||
                    Yii::$app->user->can('employee', ['allfiles' => $model->parent])
                )
            );
    }

    /**
     * @param PermissionEvent $event
     * @return bool
     */
    public function verifyFileMUploadPermission(PermissionEvent $event)
    {
        $parameters = $event->parameters;
        /**
         * @var Investigation $investigation
         * @var User $user
         */
        $investigation = $parameters['investigation'];
        $model = $parameters['model'];

        $event->isTruest = static::canMUpload($model, $investigation);

        return $event->isTruest;
    }

    /**
     * @param $model
     * @param $investigation
     * @return bool
     */
    public static function canMUpload($model, $investigation)
    {
        return (
            Yii::$app->user->can('file.multi-upload.all') ||
            (
                Yii::$app->user->can('file.multi-upload') &&
                (
                    (!empty($investigation) && Yii::$app->user->can('employee', ['investigation' => $investigation])) ||
                    Yii::$app->user->can('employee', ['allfiles' => $model->parent])
                )
            )
        );
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

        $event->isTruest = static::canDownload($investigation, $model);

        return $event->isTruest;
    }

    /**
     * @param $investigation
     * @param $model
     * @return bool
     */
    public static function canDownload($investigation, $model)
    {
        return Yii::$app->user->can('file.download.all') ||
            (
                Yii::$app->user->can('file.download') &&
                (
                    (!empty($investigation) && Yii::$app->user->can('employee',
                            ['company' => $investigation->company])) ||
                    Yii::$app->user->can('employee', ['allfiles' => $model->parent])
                )
            );
    }

    /**
     * @param PermissionEvent $event
     * @return bool|mixed
     */
    public function verifyFileMDownloadPermission(PermissionEvent $event)
    {
        $parameters = $event->parameters;
        $investigation = $parameters['investigation'];
        $model = $parameters['model'];

        $event->isTruest = self::canMDownload($investigation, $model);

        return $event->isTruest;
    }

    /**
     * @param $investigation
     * @param $model
     * @return bool
     */
    public static function canMDownload($investigation, $model)
    {
        return Yii::$app->user->can('file.multi-download.all') ||
            (
                Yii::$app->user->can('file.multi-download') &&
                (
                    (!empty($investigation) && Yii::$app->user->can('employee',
                            ['company' => $investigation->company])) ||
                    Yii::$app->user->can('employee', ['allfiles' => $model->parent])
                )
            );
    }

    /**
     * @param PermissionEvent $event
     * @return bool|mixed
     */
    public function verifyFileArchivePermission(PermissionEvent $event)
    {
        $parameters = $event->parameters;
        $investigation = $parameters['investigation'];
        $model = $parameters['model'];
        $user = \Yii::$app->user->identity;

        $event->isTruest = static::canArchive($investigation, $model, $user);

        return $event->isTruest;
    }

    /**
     * @param $investigation
     * @param $model
     * @param $user
     * @return bool
     */
    public static function canArchive($investigation, $model, $user)
    {
        return Yii::$app->user->can('file.archive.all') ||
            (
                Yii::$app->user->can('file.archive') &&
                (
                    (!empty($investigation) && Yii::$app->user->can('employee', ['investigation' => $investigation])) ||
                    (Yii::$app->user->can('employee',
                            ['allfiles' => $model->parents->parent]) && ($user->id == $model->created_by))
                )
            );
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
