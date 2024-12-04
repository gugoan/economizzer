<?php

namespace app\controllers;

use Yii;
use app\models\Bancos;
use app\models\BancosSearch;
use app\models\Faturas;
use app\models\FaturasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use yii\helpers\ArrayHelper;

class BancosController extends Controller
{
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::class,
        'rules' => [
          [
            'allow' => true,
            'roles' => ['@'],
          ],
        ],
      ],
    ];
  } // Controller
  public function actionIndex()
  {
    $searchModel = new BancosSearch();
    $selectedYear = Yii::$app->request->get('ano', date('Y')); // Ano atual como padrão

    // Adiciona o filtro de ano aos parâmetros da busca
    $queryParams = Yii::$app->request->queryParams;
    $queryParams['ano'] = $selectedYear; // Adiciona o parâmetro do ano

    // Criação do DataProvider para garantir que o banco retornado seja do usuário logado
    $dataProvider = new ActiveDataProvider([
      'query' => Bancos::find()->where(['user_id' => Yii::$app->user->id]),
      'pagination' => [
        'pageSize' => 20,
      ],
    ]);
    // Obtém todos os bancos do usuário para o modal
    $bancos = Bancos::find()->where(['user_id' => Yii::$app->user->id])->all();
    // Crie o objeto model para a criação de um novo banco

    // Passando o DataProvider para a view
    return $this->render('index', [
      'selectedYear' => $selectedYear,
      'dataProvider' => $dataProvider,
      'searchModel' => $searchModel,
      'bancos' => $bancos, // Exemplo: pega todos os bancos

    ]);
  }


  // Ação para visualizar as faturas de um banco específico
  public function actionView($id)
  {
    $banco = $this->findModel($id);

    // Instância de FaturasSearch para o filtro
    $searchModelFaturas = new FaturasSearch();
    $selectedYear = Yii::$app->request->get('ano', date('Y')); // Ano atual como padrão

    // Busca de faturas filtrando pelo ano selecionado e pelo banco
    $faturasProvider = new ActiveDataProvider([
      'query' => Faturas::find()
        ->where(['id_bancos' => $banco->id_bancos])
        ->andWhere(['YEAR(data)' => $selectedYear]), // Filtro por ano
      'pagination' => false, // Remove a paginação para mostrar todas as faturas
    ]);


    return $this->render('view', [
      'banco' => $banco,
      'searchModelFaturas' => $searchModelFaturas,
      'faturasProvider' => $faturasProvider,
      'selectedYear' => $selectedYear, // Passe a variável para a view

    ]);
  }

  // Ação para criar um novo banco
  public function actionCreate()
  {
    $model = new Bancos();

    if ($model->load(Yii::$app->request->post())) {
      $model->user_id = Yii::$app->user->id; // Definir o ID do usuário atual

      if ($model->save()) {
        return $this->redirect(['index', 'id' => $model->id_bancos]);
      }
    }

    return $this->render('create', [
      'model' => $model,
    ]);
  }

  // Ação para atualizar um banco existente
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id_bancos]);
    }

    return $this->render('update', [
      'model' => $model,
    ]);
  }

  // Ação para excluir um banco existente
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();
    return $this->redirect(['index']);
  }

  public function actionCopyFatura()
  {
    Yii::$app->response->format = Response::FORMAT_JSON;

    // Recupera os dados enviados via POST
    $faturaId = Yii::$app->request->post('fatura_id');
    $bancoId = Yii::$app->request->post('banco_id');

    // Validação básica dos dados recebidos
    if (!$faturaId || !$bancoId) {
      return [
        'success' => false,
        'message' => 'Dados inválidos.',
      ];
    }

    // Verifica se o banco de destino existe e pertence ao usuário atual
    $bancoDestino = Bancos::findOne(['id_bancos' => $bancoId, 'user_id' => Yii::$app->user->id]);

    if (!$bancoDestino) {
      return [
        'success' => false,
        'message' => 'Banco de destino inválido.',
      ];
    }

    // Encontra a fatura original que será copiada
    $faturaOriginal = Faturas::findOne($faturaId);

    if (!$faturaOriginal) {
      return [
        'success' => false,
        'message' => 'Fatura original não encontrada.',
      ];
    }

    // Cria uma nova instância de Faturas para a cópia
    $faturaCopia = new Faturas();
    $faturaCopia->descricao = $faturaOriginal->descricao;
    $faturaCopia->valor = $faturaOriginal->valor;
    $faturaCopia->parcelas = $faturaOriginal->parcelas;
    $faturaCopia->id_bancos = $bancoDestino->id_bancos;
    $faturaCopia->data = $faturaOriginal->data; // Ajuste conforme necessário
    $faturaCopia->user_id = Yii::$app->user->id; // Define o usuário atual como responsável
    $faturaCopia->category_id = $faturaOriginal->category_id; // Copia a categoria da fatura original

    // Tenta salvar a nova fatura copiada
    if ($faturaCopia->save()) {
      return [
        'success' => true,
        'message' => 'Fatura copiada com sucesso.',
      ];
    }

    // Se a cópia falhar, retorna os erros de validação
    $errors = $faturaCopia->getErrors();
    return [
      'success' => false,
      'message' => 'Ocorreu um erro ao copiar a fatura.',
      'errors' => $errors,
    ];
  }

  /**
   * Busca o modelo de banco com base no ID.
   * @param integer $id
   * @return Bancos o modelo encontrado
   * @throws NotFoundHttpException se o modelo não for encontrado
   */
  protected function findModel($id)
  {
    if (($model = Bancos::findOne(['id_bancos' => $id, 'user_id' => Yii::$app->user->id])) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('O banco solicitado não foi encontrado.');
  }
}
