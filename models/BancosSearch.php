<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bancos;

class BancosSearch extends Bancos
{
  public $date_from;
  public $date_to;
  public $ano; // Novo atributo para o ano selecionado

  public function rules()
  {
    return [
      [['id_bancos', 'user_id'], 'integer'],
      [['nome', 'descricao'], 'safe'],
      [['data_registro', 'date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
      [['ano'], 'integer'], // Validação do ano
    ];
  }

  public function scenarios()
  {
    return Model::scenarios();
  }

  public function search($params)
  {
    $query = Bancos::find()->alias('b');

    // Junção com a tabela de faturas para buscar pelo ano das faturas
    $query->joinWith('faturas f');

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'pageSize' => 10,
      ],
      'sort' => [
        'defaultOrder' => [
          'data_registro' => SORT_DESC,
        ],
      ],
    ]);

    $this->load($params);

    if (!$this->validate()) {
      return $dataProvider;
    }

    // Filtros principais
    $query->andFilterWhere([
      'b.id_bancos' => $this->id_bancos,
      'b.user_id' => $this->user_id,
    ]);

    $query->andFilterWhere(['like', 'b.nome', $this->nome])
      ->andFilterWhere(['like', 'b.descricao', $this->descricao]);

    // Filtro de data de registro com intervalo
    if ($this->date_from && $this->date_to) {
      $query->andFilterWhere(['between', 'b.data_registro', $this->date_from, $this->date_to]);
    } elseif ($this->data_registro) {
      $query->andFilterWhere(['=', 'b.data_registro', $this->data_registro]);
    }

    // Filtro pelo ano das faturas associadas
    if ($this->ano) {
      $query->andWhere(['YEAR(f.data)' => $this->ano]);
    }

    return $dataProvider;
  }
}