<?php

namespace backend\models\search;

use Yii;
use backend\models\File;
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
        $scenario = parent::scenarios();
        return array_merge($scenario, [
            self::SCENARIO_APP => ['name', 'pagesize'],
            self::SCENARIO_ALL => ['name', 'pagesize'],
        ]);
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
            if ($this->scenario == self::SCENARIO_APP) {
                if (!Yii::$app->user->can('admin'))
                    $query
                        ->joinWith(['users'])
                        ->andWhere(['user.id' => Yii::$app->user->id]);
            }
            $query->andWhere(['file.parent' => $this->parent]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at' => SORT_ASC]],
            'pagination' => [
                'route' => 'file/index',
            ],

        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'file.id' => $this->id,
            'file.size' => $this->size,
            'file.created_at' => $this->created_at,
            'file.updated_at' => $this->updated_at,
            'file.status' => $this->status,
            'file.citrix_id' => $this->citrix_id,
        ]);

        $query->andFilterWhere(['like', 'file.name', $this->name])
            ->andFilterWhere(['like', 'file.description', $this->description])
            ->andFilterWhere(['like', 'file.type', $this->type]);

        return $dataProvider;
    }

}
