<?php


namespace backend\models;


use backend\behaviors\NotifyBehavior;
use common\models\query\UndeletableActiveQuery;

class User extends \common\models\User
{
    use FactoryTrait;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['notify'] = [
            'class' => NotifyBehavior::class,
            'companyId' => function(User $model) {
                return $model->company->id;
            },
            'createTemplate' => 'user/create',
            'updateTemplate' => 'user/update',
            'deleteTemplate' => 'user/delete',
        ];

        return $behaviors;
    }

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
     * @return bool
     */
    public function isClient()
    {
        return !\Yii::$app->user->can('admin');
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
}