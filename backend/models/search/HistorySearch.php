<?php

namespace backend\models\search;

use backend\models\traits\ExtendHistoryFindConditionTrait;
use common\models\History;
use yii\data\ActiveDataProvider;

/**
 * CompanySearch represents the model behind the search form about `common\models\Company`.
 */
class HistorySearch extends History
{

    use ExtendHistoryFindConditionTrait;

    public $pagesize = 10;
    public $searchname;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'searchname', 'created_at', 'type', 'created_at'], 'safe'],
            [['pagesize'], 'integer']
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     * @internal param array $relations
     * @internal param array $where
     * @internal param array $order
     */
    public function search(array $params)
    {
        if (!empty($this->formName()) && !isset($params[$this->formName()])) {
            $params = [$this->formName() => $params];
        }

        $query = static::find();
        //exclude users
        $query->andWhere(['<>', 'type', 'user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            //'pagination' => ['defaultPageSize' => 1]
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
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->searchname])
            ->andFilterWhere(['like', 'parent', $this->parent]);

        return $dataProvider;
    }
}
