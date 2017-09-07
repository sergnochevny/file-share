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

    public $role_type;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [
                ['role_type', 'searchname', 'pagesize', 'first_name', 'last_name',
                    'phone_number', 'email', 'username', 'auth_key', 'password_hash',
                    'password_reset_token'
                ], 'safe'],
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
        if (!empty($this->formName()) && !isset($params[$this->formName()])) {
            $params = [$this->formName() => $params];
        }

        $query = static::find();
        if (!Yii::$app->user->can('sadmin')) {
            //admin can edit only company users
            $query->rightJoin('user_company', User::tableName() . '.[[id]] = [[user_company]].[[user_id]]');
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
        if (!empty($this->role_type)) {
            $roleNames = (new Query())->select(['name'])->from('auth_item')->where(['type' => $this->role_type])->column();
            $userIds = (new Query())->select(['user_id'])->from('auth_assignment')->where(['item_name' => $roleNames])->column();
            $query->andWhere(['id' => $userIds]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        $query->orFilterWhere(['like', 'first_name', $this->searchname])
            ->orFilterWhere(['like', 'last_name', $this->searchname])
            ->orFilterWhere(['like', 'email', $this->searchname])
            ->orFilterWhere(['like', 'username', $this->searchname]);

        $query->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token]);

        return $dataProvider;
    }

    public function getRole()
    {
        $roles = \Yii::$app->authManager->getRolesByUser($this->id);
        if (!empty($roles)) return array_keys($roles)[0];
        return null;
    }
}
