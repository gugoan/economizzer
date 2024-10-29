<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

class Cashbook extends \yii\db\ActiveRecord
{
    public $file;        // Arquivo de upload
    public $filename;    // Nome do arquivo original

    public function beforeSave($insert)
    {
        // Verifica se é uma nova transação ou se é uma despesa e ajusta o valor
        if ($this->isNewRecord || $this->type_id == 2) {
            $this->value = ($this->value < 0) ? $this->value : -abs($this->value);
        } else {
            $this->value = abs($this->value);
        }

        return parent::beforeSave($insert);
    }

    public static function tableName()
    {
        return 'cashbook';
    }

    public function rules()
    {
        return [
            [['category_id', 'type_id', 'value', 'date'], 'required'],
            [['category_id', 'type_id', 'user_id', 'is_pending'], 'integer'],
            [['value'], 'number'],
            [['date', 'attachment', 'file', 'filename', 'inc_datetime', 'edit_datetime'], 'safe'],
            [['description'], 'string', 'max' => 255],
            [['attachment'], 'string', 'max' => 255],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, pdf', 'maxSize' => 1024 * 1024 * 5], // 5MB máximo
        ];
    }

    // Função para retornar o caminho completo do arquivo de imagem ou PDF
    public function getFilePath()
    {
        return isset($this->attachment) ? Yii::$app->params['uploadPath'] . $this->user_id . "/" . $this->attachment : null;
    }

    // URL do arquivo para acesso na web
    public function getFileUrl()
    {
        return $this->attachment ? Yii::$app->params['uploadUrl'] . $this->user_id . '/' . $this->attachment : Yii::$app->params['uploadUrl'] . 'default-attachment.png';
    }

    // Função para fazer o upload do arquivo
    public function uploadFile()
    {
        $file = UploadedFile::getInstance($this, 'file');

        if (empty($file)) {
            return false; // Sem arquivo enviado
        }

        $this->filename = $file->name; // Nome original do arquivo

        // Armazena a divisão em partes
        $parts = explode(".", $file->name);
        $ext = end($parts); // Obtém a extensão do arquivo

        $this->attachment = Yii::$app->security->generateRandomString() . ".{$ext}"; // Nome único

        // Cria diretório se não existir
        if (!file_exists(Yii::getAlias('@webroot/uploads/'))) {
            mkdir(Yii::getAlias('@webroot/uploads/'), 0777, true);
        }

        // Caminho para salvar o arquivo
        $path = Yii::getAlias('@webroot/uploads/') . $this->user_id . '/' . $this->attachment;

        // Verifica erros de upload
        if ($file->hasError) {
            throw new \Exception("Erro ao enviar o arquivo: " . $file->error);
        }

        // Salva o arquivo no servidor
        return $file->saveAs($path) ? $file : false;
    }

    // Função para deletar o arquivo
    public function deleteFile()
    {
        $file = $this->getFilePath();

        if (empty($file) || !file_exists($file)) {
            return false;
        }

        if (!unlink($file)) {
            return false;
        }

        $this->attachment = null;
        $this->filename = null;

        return true;
    }


    // Definição dos rótulos dos campos
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
            'file' => Yii::t('app', 'File'),
            'filename' => Yii::t('app', 'Filename'),
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
