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
          // Verifica o tipo do arquivo
          $filePath = $model->getFilePath();
          $fileExtension = $model->file->extension;

          // Chama a função correta de acordo com o tipo de arquivo
          if (strtolower($fileExtension) === 'pdf') {
            $transactions = $this->extractTransactionsFromPdf($filePath);
          } elseif (strtolower($fileExtension) === 'csv') {
            $transactions = $this->extractTransactionsFromCsv($filePath);
          } else {
            Yii::$app->session->setFlash('error', 'Formato de arquivo não suportado.');
            return $this->render('uploadFaturas', [
              'model' => $model,
              'id_bancos' => $id_bancos,
            ]);
          }

          // Recupera categorias e renderiza a página de confirmação
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
          Yii::$app->session->setFlash('error', 'Erro ao fazer upload do arquivo.');
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
      $model->parcelas = $trans['parcelas'] ?? '-';  // Valor padrão se parcelas não estiver definido
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
  protected function extractTransactionsFromCsv($csvPath)
  {
    $transactions = [];

    // Mapeamento de palavras-chave para IDs de categorias
    $categoryMapping = [
      'BOTICARIO' => '1019',
      'Eudora' => '1019',
      'NATURA' => '1019',
      'COSMETIC' => '1019',
      'BEER' => '1018',
      'BURGER' => '1018',
      'Bar' => '1018',
      'RESTAURANTE' => '1018',
      '1A99' => '1021',
      'SUPERMERCADO' => '1021',
      'ATACADAO' => '1021',
      'ROFATTO' => '1021',
      'PENHA' => '1021',
      'mix' => '1021',
      'DAVID BARBOZA' => '1021',
      'PANDULANCHES' => '1021',
      'CASARAO' => '1021',
      'SUCOS' => '1021',
      'PIZZARIA' => '1021',
      'POSTO' => '1022',
      'Posto' => '1022',
      'ShellBox' => '1022',
      'ARENA' => '1022',
      'N. R.' => '1022',
      'ITAPIRENSE' => '1022',
      'PANORAMA' => '1022',
      'PHARMA' => '1023',
      'DROGARIA' => '1023',
      'CLARO' => '1029',
      'AUTO CENTER' => '1023',
      'AIRBNB' => '1027',
      'BYMA' => '1027',

      'MERCADOLIVRE' => '1024',
      'SHOPEE' => '1024',
      'Pagamentos' => '1025',
      'MP*JOSE' => '1025',
      'FABIOLUIZDAGNONI' => '1026',
      'CLEUSA' => '1018',
      'JOSE ROBERTO' => '1026',
      'LUCIANO DE ANDRADE' => '1026',
      'Mega Motos' => '1030',
      'FACEBK' => '1031',
      'SHOPIFY' => '1031',

      // Novas adições para garantir maior cobertura:
      'Skyfit' => '1028',  // Se o nome aparecer em transações de supermercado
      'Melimais' => '1025',       // Como pagamentos (baseado em "MP *Melimais")
      'ANTONELLI' => '1021',
      'Agro' => '1021',     // Agro pode ser relacionado a supermercados ou mercados
      'Amazon Prime' => '1029', // Se for referente ao serviço de streaming
      'Ton Central' => '1018',
      'Bear' => '1018', // Pode ser uma referência a bares ou restaurantes
      'Zeferinoltda' => '1023', // Farmácia (considerando o nome da empresa)
      'Tabacaria' => '1018', // Categoria de farmácias ou tabacarias
      'Spotify' => '1029',   // Pagamentos relacionados a serviços de streaming
      'Cubatao' => '1021',   // Pode se referir a supermercado ou mercado
      'Fabioluizdagnoni' => '1026', // Nome específico
      'Supermercado' => '1021', // Generalização para supermercados
      'Lojaehcases' => '1024',  // Considerando como uma loja online (Shopee)
      'Melimais' => '1025', // Pode ser considerado pagamento
      'Pg' => '1018',         // Pode se referir a restaurante ou bar (Ton Central Beer)
      'Tabacaria Jb' => '1018',  // Farmácia ou loja de tabaco
      'Supermercado Jardim P' => '1021', // Supermercado
      'Auto Posto' => '1022', // Auto posto (N. R. e Arena)
      'sem Parar' => '1025', // Pagamentos (serviços recorrentes)
      'Pandulanches' => '1021',  // Supermercado ou alimentação
    ];
    if (($handle = fopen($csvPath, "r")) !== false) {
      $headers = fgets($handle);

      while (($line = fgets($handle)) !== false) {
        $data = explode(";", $line);

        if (count($data) >= 5) {
          $date = null;
          if (isset($data[0])) {
            $dateParts = explode('/', trim($data[0]));
            if (count($dateParts) === 3) {
              $date = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
            }
          }

          $description = isset($data[1]) ? trim($data[1]) : '';
          $value = null;
          if (isset($data[3]) && strpos($data[3], 'R$') !== false) {
            $value = floatval(str_replace(['R$', ' ', ','], ['', '', '.'], trim($data[3])));
          }

          $parcelas = (isset($data[4]) && trim($data[4]) !== '-') ? trim($data[4]) : '-';

          $transaction = [
            'id_bancos' => null,
            'data' => $date,
            'descricao' => $description,
            'valor' => $value,
            'category_id' => $this->determineCategoryId($description, $categoryMapping),
            'parcelas' => $parcelas
          ];

          $transactions[] = $transaction;
        }
      }
      fclose($handle);
    }

    return $transactions;
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
      'parcelas' => '-'
    ];

    // Mapeamento de meses em português para números
    $monthMapping = [
      'jan' => '01',
      'fev' => '02',
      'mar' => '03',
      'abr' => '04',
      'mai' => '05',
      'jun' => '06',
      'jul' => '07',
      'ago' => '08',
      'set' => '09',
      'out' => '10',
      'nov' => '11',
      'dez' => '12',
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
      'DEZ' => '12',
    ];

    // Mapeamento de palavras-chave para IDs de categorias
    $categoryMapping = [
      'BOTICARIO' => '1019',
      'Eudora' => '1019',
      'NATURA' => '1019',
      'COSMETIC' => '1019',
      'BEER' => '1018',
      'BURGER' => '1018',
      'Bar' => '1018',
      'RESTAURANTE' => '1018',
      '1A99' => '1021',
      'SUPERMERCADO' => '1021',
      'ATACADAO' => '1021',
      'ROFATTO' => '1021',
      'PENHA' => '1021',
      'mix' => '1021',
      'DAVID BARBOZA' => '1021',
      'PANDULANCHES' => '1021',
      'CASARAO' => '1021',
      'SUCOS' => '1021',
      'PIZZARIA' => '1021',
      'POSTO' => '1022',
      'Posto' => '1022',
      'Shell' => '1022',
      'ARENA' => '1022',
      'N. R.' => '1022',
      'ITAPIRENSE' => '1022',
      'PANORAMA' => '1022',
      'PHARMA' => '1023',
      'DROGARIA' => '1023',
      'CLARO' => '1029',
      'AUTO CENTER' => '1023',
      'AIRBNB' => '1027',
      'BYMA' => '1027',

      'MERCADOLIVRE' => '1024',
      'SHOPEE' => '1024',
      'Pagamentos' => '1025',
      'MP*JOSE' => '1025',
      'FABIOLUIZDAGNONI' => '1026',
      'CLEUSA' => '1018',
      'JOSE ROBERTO' => '1026',
      'LUCIANO DE ANDRADE' => '1026',
      'Mega Motos' => '1030',
      'FACEBK' => '1031',
      'SHOPIFY' => '1031',

      // Novas adições para garantir maior cobertura:
      'Skyfit' => '1028',  // Se o nome aparecer em transações de supermercado
      'Melimais' => '1025',       // Como pagamentos (baseado em "MP *Melimais")
      'ANTONELLI' => '1021',
      'Agro' => '1021',     // Agro pode ser relacionado a supermercados ou mercados
      'Amazon Prime' => '1029', // Se for referente ao serviço de streaming
      'Ton Central' => '1018',
      'Bear' => '1018', // Pode ser uma referência a bares ou restaurantes
      'Zeferinoltda' => '1023', // Farmácia (considerando o nome da empresa)
      'Tabacaria' => '1018', // Categoria de farmácias ou tabacarias
      'Spotify' => '1029',   // Pagamentos relacionados a serviços de streaming
      'Cubatao' => '1021',   // Pode se referir a supermercado ou mercado
      'Fabioluizdagnoni' => '1026', // Nome específico
      'Supermercado' => '1021', // Generalização para supermercados
      'Lojaehcases' => '1024',  // Considerando como uma loja online (Shopee)
      'Melimais' => '1025', // Pode ser considerado pagamento
      'Pg' => '1018',         // Pode se referir a restaurante ou bar (Ton Central Beer)
      'Tabacaria Jb' => '1018',  // Farmácia ou loja de tabaco
      'Supermercado Jardim P' => '1021', // Supermercado
      'Auto Posto' => '1022', // Auto posto (N. R. e Arena)
      'sem Parar' => '1025', // Pagamentos (serviços recorrentes)
      'Pandulanches' => '1021',  // Supermercado ou alimentação
    ];
    // Função para determinar a categoria com base na descrição
    $determineCategoryId = function ($description, $categoryMapping) {
      foreach ($categoryMapping as $keyword => $categoryId) {
        if (stripos($description, $keyword) !== false) {
          return $categoryId;
        }
      }
      return null;
    };

    foreach ($lines as $line) {
      $trimmedLine = trim($line);

      if (empty($trimmedLine)) {
        continue;
      }

      // Verifica se a linha contém uma data no formato (1) 4 de out. 2024 ou (2) 06 SET
      if (preg_match('/(\d{1,2})\sde\s([a-záàâãäéèêíóòôõöúç]{3})\.\s(\d{4})/', $trimmedLine, $dateMatches) || preg_match('/(\d{2})\s([A-Z]{3})/', $trimmedLine, $dateMatches)) {
        $day = $dateMatches[1];
        $month = strtolower($dateMatches[2]);
        $year = isset($dateMatches[3]) ? $dateMatches[3] : date('Y'); // Assume o ano atual se não houver

        if (isset($monthMapping[$month])) {
          $currentDate = $year . '-' . $monthMapping[$month] . '-' . $day;

          if (!empty($currentTransaction['date']) && !is_null($currentTransaction['value'])) {
            $currentTransaction['category_id'] = $determineCategoryId($currentTransaction['description'], $categoryMapping);
            $transactions[] = $currentTransaction;
          }

          $currentTransaction = [
            'id_bancos' => null,
            'date' => $currentDate,
            'description' => '',
            'value' => null,
            'category_id' => null,
            'parcelas' => '-'
          ];

          $trimmedLine = str_replace($dateMatches[0], '', $trimmedLine);
        }
      }

      // Extrai o valor se a linha contiver "R$"
      if (strpos($trimmedLine, 'R$') !== false) {
        if (preg_match('/R\$\s*([-]?\d{1,3}(?:\.\d{3})*(?:,\d{2})?)/', $trimmedLine, $valueMatches)) {
          $currentTransaction['value'] = str_replace(',', '.', str_replace('.', '', $valueMatches[1]));
          $currentTransaction['value'] = abs($currentTransaction['value']);
          $trimmedLine = str_replace($valueMatches[0], '', $trimmedLine);
        }
      }

      // Extrai as parcelas se a linha contiver "Parcela"
      if (preg_match('/\(?\s*(\d+)\s*(?:de|\/)\s*(\d+)\s*\)?/', $trimmedLine, $parcelMatches)) {
        $currentTransaction['parcelas'] = "{$parcelMatches[1]} de {$parcelMatches[2]}";
        $trimmedLine = str_replace($parcelMatches[0], '', $trimmedLine);
      }

      // Adiciona a descrição
      if (!empty($trimmedLine)) {
        $currentTransaction['description'] .= empty($currentTransaction['description']) ? $trimmedLine : ' ' . $trimmedLine;
      }

      // Se a transação tiver todos os dados, adiciona a lista
      if (!empty($currentTransaction['date']) && !empty($currentTransaction['value']) && !empty($currentTransaction['description'])) {
        $currentTransaction['category_id'] = $determineCategoryId($currentTransaction['description'], $categoryMapping);
        $transactions[] = $currentTransaction;
        $currentTransaction = [
          'id_bancos' => null,
          'date' => null,
          'description' => '',
          'value' => null,
          'category_id' => null,
          'parcelas' => '-'
        ];
      }
    }

    // Garante que todas as transações tenham os campos necessários
    foreach ($transactions as &$transaction) {
      $transaction['data'] = $transaction['date'] ?? '';
      $transaction['valor'] = $transaction['value'] ?? '';
      $transaction['descricao'] = $transaction['description'] ?? '';
      $transaction['parcelas'] = $transaction['parcelas'] ?? '-';
    }

    return $transactions;
  }

  // Função para determinar o ID da categoria com base na descrição
  private function determineCategoryId($description, $categoryMapping)
  {
    // Normaliza a descrição para que a primeira letra de cada palavra seja maiúscula
    $normalizedDescription = ucwords(strtolower($description));

    // Verifica se a descrição normalizada contém a palavra-chave
    foreach ($categoryMapping as $keyword => $categoryId) {
      if (stripos($normalizedDescription, $keyword) !== false) {
        return $categoryId; // Retorna o ID da categoria correspondente
      }
    }
    return '1026'; // Retorna um ID padrão caso nenhuma categoria seja encontrada
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