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

    protected static $instance;

    public $pagesize = 10;


    /**
     * @param  null|array $params
     * @return FileSearch
     */
    public static function getInstance($params = null)
    {
        if (empty(static::$instance)) {
            static::$instance = new static($params);
        }
        return static::$instance;
    }

    protected static function extendFindConditionByPermissions(&$query)
    {
        $can = false;
        $self = static::getInstance();
        if (!empty($self->parent)) {
            if (!Yii::$app->user->can('company.find.all')) {
                $query
                    ->joinWith(['users'])
                    ->andWhere(['user.id' => Yii::$app->user->id]);
            }
            if ($self->scenario == self::SCENARIO_APP) {
            }
            $query->andWhere(['file.parent' => $self->parent]);
        }

        $permissions = ['file.find.all'];
        foreach ($permissions as $permission) {
            $can = $can || \Yii::$app->user->can($permission);
        }
        if (!$can) {
            $query->andWhere(['file.created_by' => \Yii::$app->user->id]);
        }
    }


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
        if (!empty($this->formName()) && !isset($params[$this->formName()])) {
            $params = [$this->formName() => $params];
        }
        $this->load($params);
        $query = static::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC]],
            'pagination' => ['route' => 'file/index',],

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
