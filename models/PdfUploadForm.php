<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class PdfUploadForm extends Model
{
  public $file;        // Arquivo de upload
  public $filename;    // Nome original do arquivo
  public $attachment;
  public $transactions = [];
  public $user_id;     // ID do usuário que está fazendo o upload

  // Nome da tabela no banco de dados
  public static function tableName()
  {
    return 'cashbook';
  }

  /**
   * Regras de validação do arquivo.
   */
  public function rules()
  {
    return [
      [['category_id', 'type_id', 'value', 'date', 'user_id'], 'required'],
      [['category_id', 'type_id', 'user_id', 'is_pending'], 'integer'],
      [['value'], 'number'],
      [['date', 'attachment', 'file', 'filename', 'inc_datetime', 'edit_datetime'], 'safe'],
      [['description'], 'string', 'max' => 255],
      [['attachment'], 'string', 'max' => 255],
      [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, pdf', 'maxSize' => 1024 * 1024 * 5], // 5MB máximo
      [['file'], 'file', 'extensions' => 'pdf', 'skipOnEmpty' => false, 'maxSize' => 1024 * 1024 * 5], // 5MB máximo
    ];
  }

  /**
   * Função para fazer o upload do arquivo PDF.
   * Retorna o arquivo salvo ou false em caso de erro.
   */
  public function uploadFile()
  {
    $file = UploadedFile::getInstance($this, 'file');

    // Se nenhum arquivo foi enviado, aborta o upload
    if (!$file) {
      return false;
    }

    // Armazenar o nome original do arquivo
    $this->filename = $file->name;

    // Gerar um nome único para salvar o arquivo no servidor
    $ext = pathinfo($file->name, PATHINFO_EXTENSION);
    $this->attachment = Yii::$app->security->generateRandomString() . ".{$ext}";

    // Verificar se a pasta de upload existe, caso contrário, criá-la
    $uploadPath = Yii::getAlias('@webroot/uploads/extrato/');
    if (!file_exists($uploadPath)) {
      mkdir($uploadPath, 0777, true);
    }

    // Definir o caminho completo para salvar o arquivo
    $filePath = $uploadPath . $this->attachment;

    // Verifica se houve algum erro durante o upload
    if ($file->hasError) {
      throw new \Exception("Erro ao enviar o arquivo: " . $file->error);
    }

    // Salva o arquivo no servidor e retorna o resultado do upload
    return $file->saveAs($filePath) ? $file : false;
  }

  /**
   * Função para retornar o caminho completo do arquivo PDF salvo.
   */
  public function getFilePath()
  {
    return isset($this->attachment) ? Yii::getAlias('@webroot/uploads/') . $this->attachment : null;
  }

  /**
   * Função para retornar a URL pública do arquivo PDF.
   */
  public function getFileUrl()
  {
    return $this->attachment ? Yii::$app->params['uploadUrl'] . $this->attachment : Yii::$app->params['uploadUrl'] . 'default-attachment.png';
  }

  /**
   * Função para deletar o arquivo PDF do servidor.
   */
  public function deleteFile()
  {
    $file = $this->getFilePath();

    if (empty($file) || !file_exists($file)) {
      return false;
    }

    if (!unlink($file)) {
      return false;
    }

    // Após a exclusão do arquivo, limpar os atributos
    $this->attachment = null;
    $this->filename = null;

    return true;
  }

  /**
   * Definir os rótulos dos atributos.
   */
  public function attributeLabels()
  {
    return [
      'id' => Yii::t('app', 'ID'),
      'category_id' => Yii::t('app', 'Category'),
      'type_id' => Yii::t('app', 'Type'),
      'value' => Yii::t('app', 'Value'),
      'description' => Yii::t('app', 'Description'),
      'date' => Yii::t('app', 'Date'),
      'is_pending' => Yii::t('app', 'Pending'),
      'attachment' => Yii::t('app', 'Attach'),
      'inc_datetime' => Yii::t('app', 'Created'),
      'edit_datetime' => Yii::t('app', 'Changed'),
      'file' => Yii::t('app', 'Arquivo PDF'),
      'filename' => Yii::t('app', 'Nome do Arquivo'),
    ];
  }

  // Relação com o tipo de transação
  public function getType()
  {
    return $this->hasOne(Type::className(), ['id_type' => 'type_id']);
  }

  // Relação com a categoria
  public function getCategory()
  {
    return $this->hasOne(Category::className(), ['id_category' => 'category_id']);
  }

  // Relação com o usuário
  public function getUser()
  {
    return $this->hasOne(User::className(), ['id' => 'user_id']);
  }

  // Função para calcular o total da página
  public static function pageTotal($provider, $value)
  {
    $total = 0;
    foreach ($provider as $item) {
      $total += $item[$value];
    }
    return Yii::$app->formatter->asCurrency(str_replace(',', '', $total));
  }
}