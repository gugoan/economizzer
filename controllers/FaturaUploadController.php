<?php

namespace app\controllers;

use Yii;
use app\models\FaturaPdfUploadForm;
use app\models\Faturas;
use app\models\Category;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class FaturaUploadController extends Controller
{
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::class,
        'only' => ['confirm', 'upload-faturas', 'save-faturas'],
        'rules' => [
          [
            'allow' => true,
            'roles' => ['@'],
          ],
        ],
      ],
      'verbs' => [
        'class' => VerbFilter::class,
        'actions' => [
          'delete' => ['post'],
        ],
      ],
    ];
  }

  public function actionUploadFaturas($id_bancos)
  {
    $model = new FaturaPdfUploadForm();

    if (Yii::$app->request->isPost) {
      Yii::debug($_FILES, __METHOD__); // Verifique o conteúdo de $_FILES para garantir que o arquivo está sendo enviado

      $model->file = UploadedFile::getInstance($model, 'file');
      if ($model->file === null) {
        Yii::error('Arquivo não recebido.', __METHOD__);
        Yii::$app->session->setFlash('error', 'Nenhum arquivo foi enviado.');
      } else {
        if ($model->uploadFile()) {
          // Processamento bem-sucedido
          $transactions = $this->extractTransactionsFromPdf($model->getFilePath());
          $categories = Category::find()
            ->where(['is_active' => 1, 'user_id' => Yii::$app->user->identity->id])
            ->select(['desc_category', 'id_category'])
            ->indexBy('id_category')
            ->column();

          return $this->render('confirmFaturas', [
            'transactions' => $transactions,
            'model' => $model,
            'categories' => $categories,
            'id_bancos' => $id_bancos,
          ]);
        } else {
          Yii::$app->session->setFlash('error', 'Erro ao fazer upload do arquivo PDF.');
        }
      }
    }

    return $this->render('uploadFaturas', [
      'model' => $model,
      'id_bancos' => $id_bancos,
    ]);
  }



  public function actionSaveFaturas()
  {
    $success = true;
    $transactions = Yii::$app->request->post('transactions');
    $id_bancos = Yii::$app->request->post('id_bancos'); // Recebe o id_bancos

    foreach ($transactions as $trans) {
      $model = new Faturas();
      $model->id_bancos = $id_bancos;
      $model->data = isset($trans['data']) ? date('Y-m-d', strtotime($trans['data'])) : null;
      $model->descricao = $trans['descricao'] ?? null;
      $model->parcelas = $trans['parcelas'] ?? '1/1';  // Valor padrão se parcelas não estiver definido
      $model->valor = $trans['valor'] ?? null;
      $model->category_id = $trans['category_id'] ?? null;
      $model->user_id = Yii::$app->user->id;

      // Verifica se os campos obrigatórios estão preenchidos
      if ($model->id_bancos === null || $model->data === null || $model->descricao === null || $model->valor === null) {
        Yii::error("Erro: Campos obrigatórios ausentes. Transação: " . json_encode($trans), __METHOD__);
        $success = false;
        continue;
      }

      // Salva o modelo e verifica erros
      if (!$model->save()) {
        $success = false;
        Yii::error("Erro ao salvar a fatura: " . json_encode($model->getErrors()), __METHOD__);
      }
    }

    // Feedback para o usuário
    if ($success) {
      Yii::$app->session->setFlash('success', 'Faturas salvas com sucesso.');
    } else {
      Yii::$app->session->setFlash('error', 'Houve um erro ao salvar as faturas.');
    }

    return $this->redirect(['faturas/index']);
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
      'id_bancos' => null,
      'date' => null,
      'description' => '',
      'value' => null,
      'category_id' => null,
      'parcelas' => '1/1'
    ];

    // Mapeamento de meses em português para números
    $monthMapping = [
      'JAN' => '01',
      'FEV' => '02',
      'MAR' => '03',
      'ABR' => '04',
      'MAI' => '05',
      'JUN' => '06',
      'JUL' => '07',
      'AGO' => '08',
      'SET' => '09',
      'OUT' => '10',
      'NOV' => '11',
      'DEZ' => '12'
    ];

    // Mapeamento de palavras-chave para IDs de categorias
    $categoryMapping = [
      'PIX' => '1013',
      'Rendimentos' => '1016',
      'Santander' => '1014',
      'Inter' => '1015',
    ];

    foreach ($lines as $line) {
      $trimmedLine = trim($line);

      if (empty($trimmedLine)) {
        continue;
      }

      // Verifica se a linha contém uma data no formato DD MMM (ex: 06 SET)
      if (preg_match('/(\d{2})\s([A-Z]{3})/', $trimmedLine, $dateMatches)) {
        $day = $dateMatches[1];
        $month = strtoupper($dateMatches[2]);

        if (isset($monthMapping[$month])) {
          $currentDate = date('Y') . '-' . $monthMapping[$month] . '-' . $day;

          // Adiciona a transação anterior se estiver completa
          if (!empty($currentTransaction['date']) && !is_null($currentTransaction['value'])) {
            // Determina a categoria com base na descrição antes de salvar
            $currentTransaction['category_id'] = $this->determineCategoryId($currentTransaction['description'], $categoryMapping);
            $transactions[] = $currentTransaction;
          }

          // Inicializa uma nova transação com a data extraída
          $currentTransaction = [
            'id_bancos' => null,
            'date' => $currentDate,
            'description' => '',
            'value' => null,
            'category_id' => null,
            'parcelas' => '1/1'
          ];

          $trimmedLine = trim(str_replace($dateMatches[0], '', $trimmedLine));
        }
      }

      // Extrai o valor se a linha contiver "R$"
      if (strpos($trimmedLine, 'R$') !== false) {
        if (preg_match('/R\$\s*([-]?\d{1,3}(?:\.\d{3})*(?:,\d{2})?)/', $trimmedLine, $valueMatches)) {
          $currentTransaction['value'] = str_replace(',', '.', str_replace('.', '', $valueMatches[1]));
          $currentTransaction['value'] = abs($currentTransaction['value']);
          $trimmedLine = trim(str_replace($valueMatches[0], '', $trimmedLine));
        }
      }

      // Extrai as parcelas se a linha contiver "Parcela"
      if (preg_match('/Parcela\s(\d+\/\d+)/', $trimmedLine, $parcelMatches)) {
        $currentTransaction['parcelas'] = $parcelMatches[1];
        $trimmedLine = trim(str_replace($parcelMatches[0], '', $trimmedLine));
      }

      // Adiciona a descrição
      if (!empty($trimmedLine)) {
        if (!empty($currentTransaction['description'])) {
          $currentTransaction['description'] .= ' ';
        }
        $currentTransaction['description'] .= trim($trimmedLine);
      }
    }

    // Adiciona a última transação se estiver completa
    if (!empty($currentTransaction['date']) && !is_null($currentTransaction['value'])) {
      // Determina a categoria com base na descrição antes de salvar
      $currentTransaction['category_id'] = $this->determineCategoryId($currentTransaction['description'], $categoryMapping);
      $transactions[] = $currentTransaction;
    }

    // Garante que todas as transações tenham os campos necessários
    foreach ($transactions as &$transaction) {
      $transaction['data'] = $transaction['date'] ?? '';
      $transaction['valor'] = $transaction['value'] ?? '';
      $transaction['descricao'] = $transaction['description'] ?? '';
      $transaction['parcelas'] = $transaction['parcelas'] ?? '1/1';
    }

    return $transactions;
  }

  // Função para determinar o ID da categoria com base na descrição
  private function determineCategoryId($description, $categoryMapping)
  {
    foreach ($categoryMapping as $keyword => $categoryId) {
      if (stripos($description, $keyword) !== false) {
        return $categoryId; // Retorna o ID da categoria correspondente
      }
    }
    return null; // Retorna null se nenhuma categoria for encontrada
  }


  private function determineBankId($description, $bankMapping)
  {
    foreach ($bankMapping as $keyword => $bankId) {
      if (stripos($description, $keyword) !== false) {
        return $bankId;
      }
    }
    return null;
  }
}