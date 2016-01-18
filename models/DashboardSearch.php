<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dashboard;

/**
 * DashboardSearch represents the model behind the search form about `app\models\Dashboard`.
 */
class DashboardSearch extends Dashboard
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_pending', 'user_id', 'category_id', 'type_id'], 'integer'],
            [['value'], 'number'],
            [['description', 'date', 'attachment', 'inc_datetime', 'edit_datetime'], 'safe'],
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
        $query = Dashboard::find();

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
            'value' => $this->value,
            'date' => $this->date,
            'is_pending' => $this->is_pending,
            'inc_datetime' => $this->inc_datetime,
            'edit_datetime' => $this->edit_datetime,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'type_id' => $this->type_id,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'attachment', $this->attachment]);

        return $dataProvider;
    }
}
