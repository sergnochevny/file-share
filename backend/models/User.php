<?php


namespace backend\models;

use backend\behaviors\HistoryBehavior;
use backend\models\traits\WhoIsUserTrait;
use common\models\query\UndeleteableActiveQuery;
use Yii;

/**
 * Class User
 * @package backend\models
 *
 * @property string $fullName
 * @property string|null $userRole
 * @property array $colleaguesList
 *
 * @mixin WhoIsUserTrait
 */
class User extends \common\models\User
{
    use WhoIsUserTrait;

    /**
     * Finds by role and returns ActiveQuery
     *
     * @param $role
     * @return UndeleteableActiveQuery
     */
    public static function findByRole($role)
    {
        $ids = \Yii::$app->getAuthManager()->getUserIdsByRole($role);
        $userTbl = static::tableName();

        return static::find()->andWhere(["$userTbl.id" => $ids]);
    }

    /**
     * @return User|null|\yii\web\IdentityInterface
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
     * @return string
     */
    public function getFullName()
    {
        return $this->first_name . ' ' .$this->last_name;
    }
}