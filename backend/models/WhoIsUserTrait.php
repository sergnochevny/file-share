<?php


namespace backend\models;

use Yii;

/**
 * Class WhoIsUserTrait
 * @package backend\models
 *
 * These checks not for "can user something?", they are for check "who is user"
 * because sadmin can "client" but he is not client
 */
trait WhoIsUserTrait
{
//    /**
//     * @return bool
//     */
//    public static function isEmployee()
//    {
//        return self::isClient() && Yii::$app->user->can('employee');
//    }

    /**
     * @return bool
     */
    public static function isClient()
    {
        return !Yii::$app->user->isGuest
            && Yii::$app->user->can('user')
            && !self::isAdmin() && !self::isSuperAdmin();
    }

    /**
     * @return bool
     */
    public static function isAdmin()
    {
        return Yii::$app->user->can('admin') && !self::isSuperAdmin();
    }

    /**
     * @return bool
     */
    public static function isSuperAdmin()
    {
        return Yii::$app->user->can('sadmin');
    }
}