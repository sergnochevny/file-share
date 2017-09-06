<?php

namespace backend\models\search;

use backend\models\File;
use backend\models\traits\ExtendFileFindConditionTrait;
use yii\data\ActiveDataProvider;

/**
 * FileSearch represents the model behind the search form about `backend\models\File`.
 */
class FileSearch extends File
{
    use ExtendFileFindConditionTrait;

    public $name;
    public $pagesize = 10;
//    public $parent;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', /*'parent',*/ 'pagesize'], 'safe'],
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
        if (!empty($this->formName()) && !isset($params[$this->formName()])) {
            $params = [$this->formName() => $params];
        }
        $this->load($params);
        $query = static::find();
        if (!empty($this->parent)) {
            $query->andWhere(['file.parent' => $this->parent]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC]],
            'pagination' => ['route' => 'file/index']
        ]);

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
