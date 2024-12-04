<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bancos;

class BancosSearch extends Bancos
{
  // Remova 'date_from', 'date_to' e 'ano' se não forem utilizados no formulário de busca
  // Adicione os campos do formulário de busca, se necessário
  // Neste caso, 'data_inicio_cartao' e 'data_fechamento_cartao' são usados no formulário

  public function rules()
  {
    return [
      [['id_bancos', 'user_id'], 'integer'],
      [['nome', 'descricao'], 'safe'],
      [['data_registro', 'data_inicio_cartao', 'data_fechamento_cartao'], 'date', 'format' => 'php:Y-m-d'],
      // Remova 'ano' se não estiver sendo utilizado
    ];
  }

  public function scenarios()
  {
    return Model::scenarios();
  }

  /**
   * Cria uma instância de ActiveDataProvider com base nos parâmetros de busca.
   *
   * @param array $params
   *
   * @return ActiveDataProvider
   */
  public function search($params)
  {
    // Inicia a consulta com alias 'b'
    $query = Bancos::find()->alias('b');

    // Junção com a tabela de faturas para buscar pelo ano das faturas, se necessário
    // Aqui, usamos LEFT JOIN para garantir que bancos sem faturas também sejam exibidos
    $query->joinWith(['faturas f' => function ($q) {
      $q->from(['f' => 'faturas']);
    }], true, 'LEFT JOIN');

    // Evita duplicatas caso haja múltiplas faturas
    $query->distinct();

    // Cria o ActiveDataProvider
    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'pageSize' => 10, // Ajuste conforme necessário
      ],
      'sort' => [
        'defaultOrder' => [
          'data_registro' => SORT_DESC,
        ],
      ],
    ]);

    // Carrega os parâmetros de busca
    $this->load($params);

    // Se a validação falhar, retorna o dataProvider sem aplicar filtros
    if (!$this->validate()) {
      return $dataProvider;
    }

    // Aplica filtros principais
    $query->andFilterWhere([
      'b.id_bancos' => $this->id_bancos,
      'b.user_id' => $this->user_id,
    ]);

    // Filtros de texto
    $query->andFilterWhere(['like', 'b.nome', $this->nome])
      ->andFilterWhere(['like', 'b.descricao', $this->descricao]);

    // Filtros de data de início do cartão
    if ($this->data_inicio_cartao) {
      $query->andFilterWhere(['>=', 'b.data_inicio_cartao', $this->data_inicio_cartao]);
    }

    // Filtros de data de fechamento do cartão
    if ($this->data_fechamento_cartao) {
      $query->andFilterWhere(['<=', 'b.data_fechamento_cartao', $this->data_fechamento_cartao]);
    }

    // **Opcional:** Se você deseja filtrar pelo ano das faturas
    /*
        if ($this->ano) {
            $query->andWhere(['YEAR(f.data)' => $this->ano]);
        }
        */

    return $dataProvider;
  }
}