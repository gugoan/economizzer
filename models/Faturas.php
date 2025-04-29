<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Faturas extends ActiveRecord
{
  /**
   * Define o nome da tabela associada à classe ActiveRecord.
   */
  public static function tableName()
  {
    return 'faturas';
  }

  /**
   * Regras de validação para os campos do modelo.
   */
  public function rules()
  {
    return [
      [['id_bancos', 'data', 'descricao', 'parcelas', 'valor', 'user_id', 'category_id'], 'required'],
      [['descricao'], 'string', 'max' => 255], // Limita a descrição a 255 caracteres
      [['parcelas'], 'string', 'max' => 20], // Limita o campo de parcelas
      [['id_bancos', 'user_id', 'category_id'], 'integer'],
      [['data'], 'date', 'format' => 'php:Y-m-d'],
      [['valor'], 'number', 'min' => 0, 'message' => 'O valor deve ser positivo.'],
    ];
  }

  /**
   * Labels personalizados para os campos.
   */
  public function attributeLabels()
  {
    return [
      'id_fatura' => 'ID da Fatura',
      'id_bancos' => 'Banco',
      'data' => 'Data da Fatura',
      'descricao' => 'Descrição da Fatura',
      'parcelas' => 'Parcelamento',
      'valor' => 'Valor (R$)',
      'user_id' => 'Usuário Responsável',
      'category_id' => 'Categoria',
    ];
  }

  /**
   * Relacionamento com o banco.
   */
  public function getBanco()
  {
    return $this->hasOne(Bancos::class, ['id_bancos' => 'id_bancos']);
  }

  /**
   * Relacionamento com o usuário.
   */
  public function getUser()
  {
    return $this->hasOne(User::class, ['id' => 'user_id']);
  }

  /**
   * Relacionamento com a categoria.
   */
  public function getCategory()
  {
    return $this->hasOne(Category::class, ['id_category' => 'category_id']);
  }

  /**
   * Gera um resumo amigável da fatura (para exibição em listas).
   */
  public function getResumoFatura()
  {
    return $this->descricao . ' - ' . Yii::$app->formatter->asCurrency($this->valor);
  }

  /**
   * Função para calcular o saldo total de parcelas pendentes para a fatura atual.
   */
  public function getSaldoParcelasPendentes()
  {
    // Parseia as parcelas, caso o formato seja como "3/12"
    $parcelasArray = explode('/', $this->parcelas);
    if (count($parcelasArray) == 2) {
      $parcelaAtual = (int) $parcelasArray[0];
      $totalParcelas = (int) $parcelasArray[1];

      // Calcula o saldo restante
      if ($parcelaAtual < $totalParcelas) {
        $parcelasRestantes = $totalParcelas - $parcelaAtual;
        return $parcelasRestantes * $this->valor / $totalParcelas;
      }
    }
    return null;
  }
}