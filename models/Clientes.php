<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Clientes extends ActiveRecord
{
  // Nome da tabela associada
  public static function tableName()
  {
    return 'clientes';
  }

  // Regras de validação
  public function rules()
  {
    return [
      [['nome'], 'required'], // Campo nome é obrigatório
      [['nome', 'descricao'], 'string', 'max' => 100], // Limite de caracteres para nome e descrição
      [['user_id', 'parcelas', 'category_id'], 'integer'], // user_id, parcelas e category_id devem ser inteiros
      [['data_registro', 'edit_datetime'], 'safe'], // Campos de data
      [['user_id'], 'default', 'value' => Yii::$app->user->id], // Define user_id padrão
    ];
  }


  // Rótulos dos atributos para formulários
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'nome' => 'Nome',
      'descricao' => 'Descrição', // Rótulo para a descrição
      'parcelas' => 'Parcelas', // Rótulo para o número de parcelas
      'category_id' => 'Categoria', // Rótulo para o ID da categoria
      'user_id' => 'User ID',
      'data_registro' => 'Data de Registro',
      'edit_datetime' => 'Data de Edição', // Rótulo para a data de edição
    ];
  }


  /**
   * Gets query for [[ProdutosClientes]].
   *
   * @return ActiveQuery
   */
  public function getProdutosClientes()
  {
    return $this->hasMany(ProdutosClientes::className(), ['cliente_id' => 'id']);
  }

  // Relação com a tabela ProdutosClientes
  public function getProdutos()
  {
    return $this->hasMany(ProdutosClientes::class, ['cliente_id' => 'id']); // Corrige a relação com base no cliente_id
  }
  public function getCategory()
  {
    return $this->hasOne(Category::class, ['id_category' => 'category_id']); // Corrija o nome da coluna
  }



  // Relação com a tabela User
  public function getUser()
  {
    return $this->hasOne(User::class, ['id' => 'user_id']);
  }
}
