<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ProdutosClientes extends ActiveRecord
{
  // Nome da tabela associada
  public static function tableName()
  {
    return 'produtos_clientes';
  }

  // Propriedades públicas
  public $clienteId; // Armazena o ID do cliente

  // Regras de validação
  public function rules()
  {
    return [
      [['produto', 'valor_cliente'], 'required'],
      [['id', 'clienteId', 'quantidade', 'user_id'], 'integer'], // Inclui id e clienteId aqui
      [['data', 'data_entrega'], 'safe'],
      [['valor_cliente', 'valor_pagamento'], 'number'],
      [['produto'], 'string', 'max' => 255],
      [['user_id'], 'default', 'value' => Yii::$app->user->id],
      [['clienteId'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::class, 'targetAttribute' => ['clienteId' => 'id']],
    ];
  }

  // Relação com a tabela Clientes
  public function getCliente()
  {
    return $this->hasOne(Clientes::class, ['id' => 'cliente_id']);
  }

  // Mapeia a propriedade clienteId para a coluna cliente_id do banco de dados
  public function getClienteId()
  {
    return $this->cliente_id;
  }

  // Define o valor da coluna cliente_id no banco de dados
  public function setClienteId($value)
  {
    $this->cliente_id = $value;
  }

  // Relação com a tabela User
  public function getUser()
  {
    return $this->hasOne(User::class, ['id' => 'user_id']);
  }

  // Rótulos dos atributos para formulários
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'cliente_id' => 'Cliente ID',
      'data' => 'Data',
      'data_entrega' => 'Data de Entrega',
      'produto' => 'Produto',
      'quantidade' => 'Quantidade',
      'valor_cliente' => 'Valor do Cliente',
      'valor_pagamento' => 'Valor do Pagamento',
      'user_id' => 'User ID',
    ];
  }
}
