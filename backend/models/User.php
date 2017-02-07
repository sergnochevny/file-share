<?php


namespace backend\models;


use backend\behaviors\HistoryBehavior;
use common\models\query\UndeletableActiveQuery;

class User extends \common\models\User
{
    use FactoryTrait;

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
     * @return bool
     */
    public static function isClient()
    {
        return !self::isAdmin();
    }

    /**
     * @return bool
     */
    public static function isAdmin()
    {
        return \Yii::$app->user->can('admin');
    }

    /**
     * @return array
     */
    public function getColleaguesList()
    {
        $query = $this->company ? $this->company->getUsers() : static::findByRole('admin');
        $users = $query->select(['id', 'username'])->asArray()->all();

        return array_column($users, 'username', 'id');
    }

    /**
     * @return array
     */
    public function getFullName()
    {

        return $this->first_name . ' ' .$this->last_name;
    }
}