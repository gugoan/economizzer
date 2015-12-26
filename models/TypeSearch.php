<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Type;

class TypeSearch extends Type
{

    public function rules()
    {
        return [
            [['id_type'], 'integer'],
            [['desc_type', 'hexcolor_type', 'icon_type'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Type::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_type' => $this->id_type,
        ]);

        $query->andFilterWhere(['like', 'desc_type', $this->desc_type])
            ->andFilterWhere(['like', 'hexcolor_type', $this->hexcolor_type])
            ->andFilterWhere(['like', 'icon_type', $this->icon_type]);

        return $dataProvider;
    }
}
