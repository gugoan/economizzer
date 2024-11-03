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
  }

  // Ação para listar todos os bancos
  public function actionIndex()
  {
    $searchModel = new BancosSearch();
    $selectedYear = Yii::$app->request->get('ano', date('Y')); // Ano atual como padrão

    // Adiciona o filtro de ano aos parâmetros da busca
    $queryParams = Yii::$app->request->queryParams;
    $queryParams['ano'] = $selectedYear; // Adiciona o parâmetro do ano

    // Filtro para buscar apenas as faturas do ano selecionado
    $dataProvider = $searchModel->search($queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
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
        return $this->redirect(['view', 'id' => $model->id_bancos]);
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

  // Ação para visualizar as faturas de um banco específico
  public function actionView($id)
  {
    $banco = $this->findModel($id);

    // Instância de FaturasSearch para o filtro
    $searchModelFaturas = new FaturasSearch();
    $filtroData = Yii::$app->request->queryParams;
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
      'mes' => $filtroData['mes'] ?? date('Y-m'), // Mês atual como padrão
      'id_bancos' => $banco->id_bancos, // Passando id_bancos para a view
      'selectedYear' => $selectedYear, // Passe a variável para a view
    ]);
  }
  // Busca o modelo de banco com base no ID
  protected function findModel($id)
  {
    if (($model = Bancos::findOne(['id_bancos' => $id, 'user_id' => Yii::$app->user->id])) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('O banco solicitado não foi encontrado.');
  }
}