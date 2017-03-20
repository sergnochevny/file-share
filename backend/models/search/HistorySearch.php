<?php

namespace backend\models\search;

use backend\models\User;
use common\traits\activeQuery\ActiveDataProviderAdditionalDataTrait;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\History;

/**
 * CompanySearch represents the model behind the search form about `common\models\Company`.
 */
class HistorySearch extends History
{
    use ActiveDataProviderAdditionalDataTrait;
    public $pagesize = 10;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'created_at', 'type', 'created_at'], 'safe'],
            [['pagesize'], 'integer']
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @param array $relations
     * @param array $where
     * @param array $order
     * @return ActiveDataProvider
     */
    public function search(array $params)
    {
        $query = History::find();
        //exclude users
        $query->andWhere(['<>', 'type', 'user']);

        // add conditions that should always apply here
        if (!Yii::$app->user->can('admin')) {
            /** @var User $user */
            $user = Yii::$app->user->identity;
            $query->where(
               // ['or', ['company_id' => Yii::$app->user->identity->company->id], ['company_id' => null]]
                ['company_id' => $user->company->id]
            );
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at' => SORT_ASC]],
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

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'parent', $this->parent]);

        return $dataProvider;
    }
}
