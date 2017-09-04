<?php
/**
 * Date: 02.02.2017
 * Time: 17:27
 */

namespace backend\behaviors;

use ait\auth\behaviors\ModelPermissionsBehavior;
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
    const EVENT_VERIFY_FILE_PERMISSION = 'verifyFilePermission';
    const EVENT_VERIFY_FILE_DOWNLOAD_PERMISSION = 'verifyFileDownloadPermission';

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
            self::EVENT_VERIFY_FILE_PERMISSION => 'verifyFilePermission',
            self::EVENT_VERIFY_FILE_DOWNLOAD_PERMISSION => 'verifyFileDownloadPermission',
            UndeleteableActiveRecord::EVENT_BEFORE_ARCHIVE => 'beforeArchive'
        ]);
    }

    /**
     * @param PermissionEvent $event
     * @return bool|mixed
     */
    public function verifyFilePermission(PermissionEvent $event)
    {
        $event->isTruest = (
            Yii::$app->user->can('sadmin') || Yii::$app->user->can('admin') ||
            (
                !Yii::$app->user->can('sadmin') && !Yii::$app->user->can('admin') ||
                Yii::$app->user->can('employee', $event->parameters)
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
    public function beforeArchive(ModelEvent $event)
    {
        return $event->isValid = $this->checkPermission();
    }
}
