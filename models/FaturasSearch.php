<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Faturas;

class FaturasSearch extends Faturas
{
  public $mes; // Campo de filtro para o mês
  public $ano; // Campo de filtro para o ano

  /**
   * Define as regras de validação para os campos de pesquisa.
   */
  public function rules()
  {
    return [
      [['id_fatura', 'id_bancos', 'user_id', 'category_id'], 'integer'],
      [['data', 'descricao', 'mes', 'ano'], 'safe'],
      [['valor'], 'number'],
    ];
  }

  /**
   * Define cenários personalizados para o modelo de pesquisa.
   */
  public function scenarios()
  {
    return Model::scenarios();
  }

  /**
   * Configura e retorna o ActiveDataProvider para a pesquisa.
   *
   * @param array $params Parâmetros de pesquisa.
   * @param int|null $id_bancos ID do banco, opcional.
   * @param int|null $mes Filtro de mês, opcional.
   * @param int|null $ano Filtro de ano, opcional.
   * @return ActiveDataProvider
   */
  public function search($params, $id_bancos = null, $mes = null, $ano = null)
  {
    $query = Faturas::find();

    // Filtro por banco, se especificado
    if ($id_bancos !== null) {
      $query->andWhere(['id_bancos' => $id_bancos]);
    }

    // Configuração do ActiveDataProvider com paginação e ordenação
    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'pageSize' => 10,
      ],
      'sort' => [
        'defaultOrder' => [
          'data' => SORT_DESC,
        ]
      ],
    ]);

    // Carrega os parâmetros e verifica a validação
    $this->load($params);
    if (!$this->validate()) {
      return $dataProvider;
    }

    // Filtros básicos
    $query->andFilterWhere([
      'id_fatura' => $this->id_fatura,
      'id_bancos' => $this->id_bancos,
      'user_id' => $this->user_id,
      'category_id' => $this->category_id,
      'valor' => $this->valor,
    ]);

    // Filtro por descrição (busca parcial)
    $query->andFilterWhere(['like', 'descricao', $this->descricao]);

    // Filtro de mês e ano (se fornecidos)
    if ($mes !== null) {
      $query->andWhere(['MONTH(data)' => $mes]);
    }
    if ($ano !== null) {
      $query->andWhere(['YEAR(data)' => $ano]);
    }

    return $dataProvider;
  }
}