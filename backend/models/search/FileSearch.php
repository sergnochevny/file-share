<?php

namespace backend\models\search;

use backend\models\File;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FileSearch represents the model behind the search form about `backend\models\File`.
 */
class FileSearch extends File
{
    const SCENARIO_APP = 'app';
    const SCENARIO_ALL = 'all';

    public $pagesize = 10;

    public function scenarios()
    {
        return [
            self::SCENARIO_LOGIN => ['name', 'pagesize'],
            self::SCENARIO_REGISTER => ['name', 'pagesize'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'pagesize'], 'safe'],
        ];
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
        $query = File::find();
        if (!empty($this->parent)) {
            if($this->scenario == self::SCENARIO_APP ){
                $query
                    ->joinWith(['investigation'])
                    ->andWhere(['user.id'=>Yii::$app->user->id]);
            }
            $query->andWhere(['parent' => $this->parent]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'size' => $this->size,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'citrix_id' => $this->citrix_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }

    /**
     * @return UndeletableActiveQuery
     */
    public function getInvestigations()
    {
        return $this->hasMany(Investigation::class, ['parent' => 'citrix_id'])->inverseOf('file');
    }

}
