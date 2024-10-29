<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class TargetSearch extends Target
{
  public function search($params)
  {
    $query = Target::find(); // Substitua 'Target' pelo seu modelo de destino

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
    ]);

    // Carregar os parâmetros de busca
    $this->load($params);

    // Você pode adicionar condições aqui, se necessário
    // Por exemplo:
    // if (!$this->validate()) {
    //     return $dataProvider; // Retorne sem filtro se a validação falhar
    // }

    return $dataProvider;
  }
}
