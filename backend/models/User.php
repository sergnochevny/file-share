<?php


namespace backend\models;


use backend\behaviors\HistoryBehavior;
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
        $behaviors['historyBehavior'] = [
            'class' => HistoryBehavior::class,
            'parent' => function(User $model){
                return $model->id;
            },
            'type' => 'user',
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

        return static::find()->andWhere(['id' => $ids]);
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