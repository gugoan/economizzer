<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class FaturaPdfUploadForm extends Model
{
  public $file;           // Arquivo de upload
  public $filename;       // Nome original do arquivo
  public $attachment;     // Nome do arquivo salvo
  public $transactions = [];
  public $user_id;        // ID do usuário que está fazendo o upload

  public static function tableName()
  {
    return 'faturas';
  }

  /**
   * Regras de validação para o modelo de fatura PDF.
   */
  public function rules()
  {
    return [
      [['file'], 'file', 'extensions' => 'pdf', 'skipOnEmpty' => false, 'maxSize' => 1024 * 1024 * 5], // Máx. 5MB
      [['user_id'], 'integer'],
      [['filename', 'attachment'], 'string', 'max' => 255],
      [['transactions'], 'safe'],  // Lista de transações extraídas do PDF
    ];
  }

  /**
   * Método para fazer o upload do arquivo PDF.
   * Retorna o nome do arquivo salvo ou false em caso de erro.
   */
  public function uploadFile()
  {
    $file = UploadedFile::getInstance($this, 'file');

    if (!$file) {
      Yii::error('Nenhum arquivo enviado.', __METHOD__);
      return false;
    }

    $this->filename = $file->name;
    $this->attachment = Yii::$app->security->generateRandomString() . '.' . $file->extension;

    $uploadPath = Yii::getAlias('@webroot/uploads/faturas/');
    if (!file_exists($uploadPath)) {
      mkdir($uploadPath, 0777, true);
    }

    $filePath = $uploadPath . $this->attachment;

    if ($file->saveAs($filePath)) {
      return true;
    }

    Yii::error('Falha ao salvar o arquivo: ' . json_encode($file->error), __METHOD__);
    return false;
  }

  /**
   * Função para retornar o caminho completo do arquivo PDF salvo.
   */
  public function getFilePath()
  {
    return isset($this->attachment) ? Yii::getAlias('@webroot/uploads/faturas/') . $this->attachment : null;
  }

  /**
   * Função para retornar a URL pública do arquivo PDF.
   */
  public function getFileUrl()
  {
    return $this->attachment ? Yii::$app->params['uploadUrl'] . 'faturas/' . $this->attachment : null;
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

    // Limpar atributos relacionados ao arquivo
    $this->attachment = null;
    $this->filename = null;

    return true;
  }

  /**
   * Rótulos dos atributos para facilitar a exibição.
   */
  public function attributeLabels()
  {
    return [
      'file' => 'Arquivo PDF da Fatura',
      'filename' => 'Nome do Arquivo',
      'attachment' => 'Arquivo Anexado',
    ];
  }
}