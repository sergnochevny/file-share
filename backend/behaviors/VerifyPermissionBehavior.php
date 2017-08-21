<?php
/**
 * Date: 02.02.2017
 * Time: 17:27
 */

namespace backend\behaviors;

use Yii;
use yii\base\Behavior;

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


    /**
     * @return array
     */
    public function events()
    {
        return [
            self::EVENT_VERIFY_FILE_PERMISSION => 'verifyFilePermission',
            self::EVENT_VERIFY_FILE_DOWNLOAD_PERMISSION => 'verifyFileDownloadPermission'
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
        $prms = $event->parameters;
        $investigation = $prms['investigation'];
        $model = $prms['model'];

        $event->isTruest = (Yii::$app->user->can('admin') || Yii::$app->user->can('sadmin') ||
            (
                !Yii::$app->user->can('admin') && !Yii::$app->user->can('sadmin') &&
                ((!empty($investigation) && Yii::$app->user->can('employee', ['investigation' => $investigation])) ||
                    (Yii::$app->user->can('employee', ['allfiles' => $model->parents->parent])))
            )
        );

        return $event->isTruest;
    }

}
