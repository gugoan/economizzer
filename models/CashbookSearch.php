<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cashbook;

class CashbookSearch extends Cashbook
{
    public $start_date;
    public $end_date;
    
    public function rules()
    {
        return [
            [['id', 'category_id', 'type_id', 'is_pending', 'account_id'], 'integer'],
            [['value'], 'number'],
            [['start_date', 'end_date'], 'date', 'format'=>'yyyy-mm-dd', 'message' => 'Data inválida!'],
            [['description', 'date', 'start_date', 'end_date', 'attachment', 'inc_datetime', 'edit_datetime'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Cashbook::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC, 
                ]
            ],
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'type_id' => $this->type_id,
            'value' => $this->value,
            //'date' => $this->date,
            //'date1' => $this->date1,
            //'date2' => $this->date2,
            //'is_pending' => $this->is_pending,
            'inc_datetime' => $this->inc_datetime,
            'edit_datetime' => $this->edit_datetime,
            'user_id' => Yii::$app->user->identity->id,
            'account_id' => $this->account_id,
        ]);

        $query->andFilterWhere(['between', 'date', $this->start_date, $this->end_date]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'attachment', $this->attachment]);

        //$query->andFilterWhere(['user_id' => 2]);

        return $dataProvider;
    }
}
