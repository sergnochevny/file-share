<?php


namespace backend\models;


use backend\behaviors\HistoryBehavior;
use common\models\query\UndeletableActiveQuery;
use Yii;

/**
 * Class User
 * @package backend\models
 *
 * @mixin WhoIsUserTrait
 */
class User extends \common\models\User
{
    use FactoryTrait;
    use WhoIsUserTrait;

    /**
     * Finds by role and returns ActiveQuery
     *
     * @param $role
     * @return UndeletableActiveQuery
     */
    public static function findByRole($role)
    {
        $ids = \Yii::$app->getAuthManager()->getUserIdsByRole($role);
        $userTbl = static::tableName();

        return static::find()->andWhere(["$userTbl.id" => $ids]);
    }

    /**
     * @return null|User
     */
    public static function getIdentity()
    {
        return \Yii::$app->getUser()->identity;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['historyBehavior'] = [
            'class' => HistoryBehavior::class,
            'parent' => function (User $model) {
                return $model->id;
            },
            'company' => function (User $model) {
                return $model->company->id;
            },
            'attribute' => 'username',
            'type' => 'user',
        ];

        return $behaviors;
    }


    /**
     * @return array
     */
    public function getColleaguesList()
    {
        $query = $this->company ? $this->company->getUsers() : static::findByRole($this->getUserRole());
        $users = $query->select(['id', 'username'])->asArray()->all();

        return array_column($users, 'username', 'id');
    }

    /**
     * @return string|null
     */
    public function getUserRole()
    {
        $roles = array_keys(Yii::$app->getAuthManager()->getRolesByUser($this->id));
        return isset($roles[0]) ? $roles[0] : null;
    }

    /**
     * @return array
     */
    public function getFullName()
    {

        return $this->first_name . ' ' .$this->last_name;
    }
}