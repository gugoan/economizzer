<?php

namespace app\controllers;

use Yii;
use app\models\PdfUploadForm;
use app\models\Cashbook;
use app\models\Category;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class PdfUploadController extends Controller
{
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::classname(),
        'only' => ['confirm', 'upload'],
        'rules' => [
          [
            'allow' => true,
            'roles' => ['@']
          ],
        ]
      ],
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'delete' => ['post'],
        ],
      ],
    ];
  }

  public function actionUpload()
  {
    $model = new PdfUploadForm();

    if (Yii::$app->request->isPost) {
      // Carregar o arquivo enviado
      $model->file = UploadedFile::getInstance($model, 'file');

      // Verifica se o upload foi bem-sucedido
      if ($model->uploadFile(Yii::$app->user->identity->id)) {
        // Extrair as transações do PDF
        $transactions = $this->extractTransactionsFromPdf($model->getFilePath(Yii::$app->user->identity->id));

        // Obter categorias ativas do usuário
        $categories = Category::find()
          ->where(['is_active' => 1, 'user_id' => Yii::$app->user->identity->id])
          ->select(['desc_category', 'id_category'])
          ->indexBy('id_category')
          ->column();
        return $this->render('confirm', [
          'transactions' => $transactions,
          'model' => $model,
          'categories' => $categories,  // Passa as categorias para a visualização
        ]);
      } else {
        Yii::$app->session->setFlash('error', 'Erro ao fazer upload do arquivo PDF.');
      }
    }

    return $this->render('upload', ['model' => $model]);
  }
  public function actionSave()
  {
    $success = true;
    $transactions = Yii::$app->request->post('transactions');

    Yii::info("Dados recebidos: " . json_encode($transactions), __METHOD__);

    foreach ($transactions as $trans) {
      $model = new Cashbook();
      $model->user_id = Yii::$app->user->id;
      $model->date = isset($trans['date']) ? date('Y-m-d', strtotime($trans['date'])) : null;
      $model->description = $trans['description'] ?? null;
      $model->value = $trans['value'] ?? null;
      $model->category_id = $trans['category_id'] ?? null;
      $model->type_id = $trans['type_id'] ?? null;
      $model->is_pending = 0; // Define is_pending como 0
      $model->inc_datetime = date("Y-m-d H:i:s");
      $model->edit_datetime = date("Y-m-d H:i:s");

      // Verifica se o tipo não é nulo
      if ($model->type_id === null) {
        Yii::error("Erro: o campo 'type_id' não pode ser nulo. Transação: " . json_encode($trans), __METHOD__);
        $success = false;
        continue;
      }

      // Adiciona depuração para verificar o valor antes de salvar
      Yii::info("Valor antes de salvar: " . $model->value, __METHOD__);

      // Salva o modelo e verifica erros
      if (!$model->save()) {
        $success = false;
        Yii::error("Erro ao salvar a transação: " . json_encode($model->getErrors()), __METHOD__);
      } else {
        $this->processTransactions();
      }
    }

    // Feedback para o usuário
    if ($success) {
      Yii::$app->session->setFlash('success', 'Transações salvas com sucesso.');
    } else {
      Yii::$app->session->setFlash('error', 'Houve um erro ao salvar as transações.');
    }

    return $this->redirect(['cashbook/index']);
  }



  protected function processTransactions()
  {
    // Obtém as transações do banco de dados
    $transactions = Cashbook::find()->where(['<', 'value', 0])->andWhere(['type_id' => 1])->all();

    foreach ($transactions as $transaction) {
      // Converte o valor para positivo
      $transaction->value = abs($transaction->value);

      // Salva as alterações no banco de dados
      if (!$transaction->save()) {
        // Aqui você pode adicionar tratamento de erro, se necessário
        Yii::$app->session->setFlash('error', 'Error processing transaction ID ' . $transaction->id);
      }
    }
  }


  protected function extractTransactionsFromPdf($pdfPath)
  {
    $transactions = [];
    $pdf = new \Smalot\PdfParser\Parser();
    $document = $pdf->parseFile($pdfPath);
    $text = $document->getText();

    // Explodir o texto em linhas
    $lines = explode("\n", $text);
    $currentTransaction = [
      'date' => null,
      'description' => '',
      'value' => null,
      'category_id' => null,
      'type_id' => null, // Adiciona o campo para tipo
      'original_value' => null // Novo campo para armazenar o valor original
    ];

    // Mapeamento de palavras-chave para IDs de categorias
    $categoryMapping = [
      'PIX' => '1013',
      'Rendimentos' => '1016',
      'Santander' =>  '1014',
      'Inter' => '1015',
    ];

    // Palavras-chave para identificar linhas irrelevantes
    $irrelevantKeywords = [
      'Saldo final',
      'ID da operação',
      'Valor',
      'Saldo',
      'Página',
      '2/',
      '3/'
    ];

    foreach ($lines as $line) {
      $trimmedLine = trim($line);

      if (empty($trimmedLine)) {
        continue; // Ignorar linhas vazias
      }

      // Ignorar linhas irrelevantes que contêm palavras-chave
      $skipLine = false;
      foreach ($irrelevantKeywords as $keyword) {
        if (stripos($trimmedLine, $keyword) !== false) {
          $skipLine = true;
          break;
        }
      }
      if ($skipLine) {
        continue;
      }

      // Ignorar linhas que contenham apenas números isolados ou sequências tipo "2/3"
      if (preg_match('/^\d+(\/\d+)?$/', $trimmedLine)) {
        continue; // Ignora números isolados ou sequências como "2/3"
      }

      // Verifica se a linha contém uma data no formato DD-MM-AAAA
      if (preg_match('/(\d{2}-\d{2}-\d{4})/', $trimmedLine, $dateMatches)) {
        // Se houver uma transação atual, armazena-a
        if (!empty($currentTransaction['date']) && !is_null($currentTransaction['value'])) {
          $currentTransaction['category_id'] = $this->determineCategoryId($currentTransaction['description'], $categoryMapping);

          // Converte valor negativo para positivo antes de armazenar
          if ($currentTransaction['value'] < 0) {
            $currentTransaction['value'] = abs($currentTransaction['value']);
          }

          $transactions[] = $currentTransaction;
        }

        // Reiniciar a transação atual com a nova data
        $currentTransaction = [
          'date' => $dateMatches[1],
          'description' => '',
          'value' => null,
          'category_id' => null,
          'type_id' => null, // Reseta o tipo para cada nova transação
          'original_value' => null // Reseta o valor original
        ];

        // Remove a data da linha para que não apareça na descrição
        $trimmedLine = trim(str_replace($dateMatches[0], '', $trimmedLine));
      }

      // Verifica se a linha contém um valor após "R$"
      if (strpos($trimmedLine, 'R$') !== false) {
        // Captura o valor após "R$" usando regex
        if (preg_match('/R\$\s*([-]?\d{1,3}(?:\.\d{3})*(?:,\d{2})?)/', $trimmedLine, $valueMatches)) {

          $currentTransaction['value'] = str_replace(',', '.', str_replace('.', '', $valueMatches[1]));

          // Garante que o valor seja sempre positivo ao salvar
          $currentTransaction['value'] = abs($currentTransaction['value']);

          // Define o tipo baseado no valor (pode continuar negativo para fins de categoria)
          $currentTransaction['type_id'] = (strpos($valueMatches[1], '-') === 0) ? '2' : '1'; // 2 para despesa, 1 para receita

          // Remove o valor da linha para que não interfira na descrição
          $trimmedLine = trim(str_replace($valueMatches[0], '', $trimmedLine));
        }
      }


      // Remove IDs numéricos longos (como "88410292207") que seguem a descrição
      if (preg_match('/(\D+)(\d{8,})/', $trimmedLine, $descriptionMatches)) {
        $trimmedLine = $descriptionMatches[1]; // Captura apenas a parte textual da descrição
      }

      // Remover quaisquer números restantes que venham após a descrição (evita IDs e outros números irrelevantes)
      $trimmedLine = preg_replace('/\b\d{8,}\b/', '', $trimmedLine); // Remove números com 8 ou mais dígitos

      // Remover valores monetários da descrição, se presentes
      $trimmedLine = preg_replace('/R\$\s*[-]?\d{1,3}(?:\.\d{3})*(?:,\d{2})?/', '', $trimmedLine); // Remove valores monetários restantes

      // Adiciona qualquer conteúdo restante como descrição, se houver
      if (!empty($trimmedLine)) {
        if (!empty($currentTransaction['description'])) {
          $currentTransaction['description'] .= ' '; // Adiciona espaço se já houver descrição
        }
        $currentTransaction['description'] .= trim($trimmedLine); // Adiciona à descrição
      }
    }

    // Adiciona a última transação se houver
    if (!empty($currentTransaction['date']) && !is_null($currentTransaction['value'])) {
      if (empty($currentTransaction['description'])) {
        $currentTransaction['description'] = 'Rendimentos'; // Atribui 'Rendimentos' se a descrição estiver vazia
      }
      $currentTransaction['category_id'] = $this->determineCategoryId($currentTransaction['description'], $categoryMapping);

      // Converte valor negativo para positivo antes de armazenar
      if ($currentTransaction['value'] < 0) {
        $currentTransaction['value'] = abs($currentTransaction['value']);
      }

      $transactions[] = $currentTransaction;
    }

    // Limpeza: remove transações sem data ou valor
    $transactions = array_filter($transactions, function ($transaction) {
      return !empty($transaction['date']) && !is_null($transaction['value']);
    });

    return $transactions;
  }

  private function determineCategoryId($description, $categoryMapping)
  {
    foreach ($categoryMapping as $keyword => $categoryId) {
      if (stripos($description, $keyword) !== false) {
        return $categoryId; // Retorna o ID da categoria correspondente
      }
    }
    return null; // Retorna null se nenhuma categoria for encontrada
  }
}
