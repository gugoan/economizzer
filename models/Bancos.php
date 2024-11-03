<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "bancos".
 *
 * @property int $id
 * @property string $nome
 * @property string $descricao
 * @property string $data_registro
 * @property string $data_inicio_cartao
 * @property string $data_fechamento_cartao
 */
class Bancos extends ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'bancos';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['nome', 'descricao', 'data_registro', 'data_inicio_cartao', 'data_fechamento_cartao'], 'required'],
      [['data_registro', 'data_inicio_cartao', 'data_fechamento_cartao'], 'date', 'format' => 'php:Y-m-d'],
      [['nome'], 'string', 'max' => 255],
      [['descricao'], 'string'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'nome' => 'Nome do Banco',
      'descricao' => 'Descrição',
      'data_registro' => 'Data de Registro',
      'data_inicio_cartao' => 'Data de Início do Cartão',
      'data_fechamento_cartao' => 'Data de Fechamento do Cartão',
    ];
  }


  /**
   * Retorna a lista de bancos para exibição em dropdowns ou listas.
   */
  public static function getBankList()
  {
    return self::find()
      ->select(['nome', 'id_bancos'])
      ->orderBy(['nome' => SORT_ASC])
      ->indexBy('id_bancos')
      ->column();
  }

  /**
   * Relacionamento com faturas associadas ao banco.
   */
  public function getFaturas()
  {
    return $this->hasMany(Faturas::class, ['id_bancos' => 'id_bancos']);
  }

  /**
   * Relacionamento com o usuário associado.
   */
  public function getUser()
  {
    return $this->hasOne(User::class, ['id' => 'user_id']);
  }

  /**
   * Calcula o total das faturas associadas ao banco.
   *
   * @return float Total das faturas
   */
  public function getTotalFaturas()
  {
    return $this->getFaturas()->sum('valor');
  }
}