<?php

namespace backend\models\search;

use common\models\Investigation;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * InvestigationSearch represents the model behind the search form about `common\models\Investigation`.
 */
class InvestigationSearch extends Investigation
{

    public $pagesize = 10;
    public $name;
    public $company_name;
    public $parent;

    protected static function extendFindConditionByPermissions(&$query)
    {
        $permissions = ['investigation.find.all'];
        $can = false;
        foreach ($permissions as $permission) {
            $can = $can || \Yii::$app->user->can($permission);
        }
        if (!$can) {
            $permissions = ['investigation.find.group'];
            $can = false;
            foreach ($permissions as $permission) {
                $can = $can || \Yii::$app->user->can($permission);
            }
            if (!$can) {
                $query->andWhere(['investigation.created_by' => \Yii::$app->user->id]);
            }
        } else {
            if(!\Yii::$app->user->can('company.find.all')) {
                $query->joinWith('users');
                $query->andWhere(['user.id' => \Yii::$app->user->id]);
            }
        }
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'pagesize', 'start_date', 'end_date', 'description'], 'safe'],
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
        $query = static::find()->joinWith('company');
//        if (!empty($this->parent)) {
//            $query->andWhere(['investigation.company_id' => $this->parent]);
//        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC]],
        ]);

        $dataProvider->sort->attributes['company_name'] = ([
            'asc' => ['company.name' => SORT_ASC],
            'desc' => ['company.name' => SORT_DESC],
            'label' => 'Company',
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'company_id' => $this->company_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);
        $query->andFilterWhere([
            'OR',
            ['like', 'company.name', $this->name],
            ['like', 'investigation.name', $this->name],
        ]);
        return $dataProvider;
    }
}
