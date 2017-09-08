<?php

namespace backend\models\search;

use ait\rbac\Item;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use yii\db\Query;
use yii\rbac\Role;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{
    public $pagesize = 10;
    public $searchname;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [
                [
                    'role_type',
                    'searchname',
                    'pagesize',
                    'first_name',
                    'last_name',
                    'phone_number',
                    'email',
                    'username',
                    'auth_key',
                    'password_hash',
                    'password_reset_token'
                ],
                'safe'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $user = \Yii::$app->user->identity;
        /**
         * @var User $user
         */
        if (!empty($this->formName()) && !isset($params[$this->formName()])) {
            $params = [$this->formName() => $params];
        }

        $query = static::find();
        //admin can edit only company users

        $query
            ->leftJoin('auth_assignment', 'auth_assignment.user_id = user.id')
            ->leftJoin('auth_item', 'auth_item.name = auth_assignment.item_name')
            ->where(['auth_item.type' => Item::TYPE_CUSTOM_ROLE]);
        if (!empty($user->company)) {
            $query
                ->rightJoin('user_company', 'user.id = user_company.user_id')
                ->where(['user_company.company_id' => $user->company->id]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'user.id' => $this->id,
            'user.status' => $this->status,
            'user.created_at' => $this->created_at,
            'user.updated_at' => $this->updated_at,
        ]);
        $query->orFilterWhere(['like', 'user.first_name', $this->searchname])
            ->orFilterWhere(['like', 'user.last_name', $this->searchname])
            ->orFilterWhere(['like', 'user.email', $this->searchname])
            ->orFilterWhere(['like', 'user.username', $this->searchname]);

        $query->andFilterWhere(['like', 'user.phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'user.auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'user.password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'user.password_reset_token', $this->password_reset_token]);

        return $dataProvider;
    }

    public function getRole()
    {
        $roles = \Yii::$app->authManager->getRolesByUser($this->id);
        if (!empty($roles)) {
            return array_keys($roles)[0];
        }
        return null;
    }
}
