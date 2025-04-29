<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class ClientesSearch extends Model
{
  public $id;
  public $nome;
  public $user_id; // Adicione o user_id se quiser filtrar por ele
  public $data_registro;

  public function rules()
  {
    return [
      [['id', 'user_id'], 'integer'],
      [['nome'], 'safe'],
      [['data_registro'], 'date', 'format' => 'php:Y-m-d'], // Ajuste para data se necessário
    ];
  }

  public function search($params)
  {
    // Cria a consulta para Clientes
    $query = Clientes::find();

    // Define a paginação e o tamanho da página
    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'pageSize' => 10, // Ajuste conforme necessário
      ],
    ]);

    // Carrega os parâmetros na busca
    $this->load($params);

    // Valida os parâmetros carregados
    if (!$this->validate()) {
      return $dataProvider; // Retorna todos os registros se a validação falhar
    }

    // Filtros
    $query->andFilterWhere(['id' => $this->id])
      ->andFilterWhere(['like', 'nome', $this->nome])
      ->andFilterWhere(['user_id' => $this->user_id]);

    // Filtragem pela data de registro
    if ($this->data_registro) {
      $query->andFilterWhere(['date(data_registro)' => $this->data_registro]);
    }

    return $dataProvider;
  }
}
