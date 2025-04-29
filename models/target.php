<?php

namespace app\models;

use Yii;

class Target extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    // Nome da tabela associada a este modelo
    return 'targets';
  }

  public $value;
  public $target_date; // Adicione essa linha se a coluna existir na tabela
  public $user_id; // Adicione esta linha
  public $file;
  public $target_value;
  public $due_date;
  public $forecast_status;
  public $created_at;
  public $updated_at;
  public $is_completed;
  public $title; // Adicione esta linha
  public $description; // Adicione esta linha
  public $status; // Adicione esta linha

  public function rules()
  {
    return [
      // Definindo que esses campos são obrigatórios
      [['title', 'description', 'target_value', 'due_date'], 'required'],
      [['status'], 'string', 'max' => 50], // Validação para o campo status
      // Validando que o campo `target_value` seja numérico
      [['target_value'], 'number'],
      // Validando que o campo `due_date` seja uma data
      [['due_date'], 'safe'],
      // Validando o comprimento máximo da descrição
      [['description'], 'string', 'max' => 255],
      // Previsão será uma string limitada a 50 caracteres
      [['forecast_status'], 'string', 'max' => 50],
      [['is_completed'], 'boolean'],
      [['file'], 'file', 'extensions' => 'pdf'],
    ];
  }

  public function attributeLabels()
  {
    // Definindo rótulos amigáveis para os campos
    return [
      'id' => Yii::t('app', 'ID'),
      'title' => Yii::t('app', 'Title'), // Adicionando o rótulo para title
      'description' => Yii::t('app', 'Description'),
      'target_value' => Yii::t('app', 'Target Value'),
      'due_date' => Yii::t('app', 'Due Date'),
      'forecast_status' => Yii::t('app', 'Forecast Status'),
      'created_at' => Yii::t('app', 'Created At'),
      'updated_at' => Yii::t('app', 'Updated At'),
      'status' => Yii::t('app', 'Status'), // Adicionando o rótulo para status
    ];
  }

  public function getType()
  {
    return $this->hasOne(Type::className(), ['id_type' => 'type_id']);
  }

  public function getCategory()
  {
    return $this->hasOne(Category::className(), ['id_category' => 'category_id']);
  }

  /**
   * Método para adicionar uma previsão para a meta (IA será usada aqui futuramente)
   */
  public function forecastStatus()
  {
    // Exemplo de lógica de previsão. Aqui será integrado a IA posteriormente.
    // Atualmente, apenas retornamos um status de exemplo.
    return 'Pending'; // Exemplo estático por enquanto
  }
}
