<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Category;

class CategorySearch extends Category
{
    public function rules()
    {
        return [
            [['id_category', 'parent_id', 'is_active'], 'integer'],
            [['desc_category', 'hexcolor_category'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Category::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'parent_id' => SORT_ASC,
                    'desc_category' => SORT_ASC, 
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
            'id_category' => $this->id_category,
            'is_active' => $this->is_active,
            'user_id' => Yii::$app->user->identity->id,
        ]);

        $query->andFilterWhere(['like', 'desc_category', $this->desc_category])
            ->andFilterWhere(['like', 'hexcolor_category', $this->hexcolor_category]);

        return $dataProvider;
    }
}
