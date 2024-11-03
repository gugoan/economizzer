<?php

namespace app\controllers;

use Yii;
use app\models\Faturas;
use app\models\FaturasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

class FaturasController extends Controller
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

  public function actionIndex()
  {
    $searchModel = new FaturasSearch();

    // Obter o id_bancos, mes e ano do usuário (são opcionais)
    $id_bancos = Yii::$app->request->get('id_bancos');
    $mes = Yii::$app->request->get('mes');
    $ano = Yii::$app->request->get('ano');
    // Defina o mês e o ano padrão
    $selectedYear = Yii::$app->request->get('ano', date('Y')); // Ano atual por padrão
    $selectedMonth = Yii::$app->request->get('mes', date('n')); // Mês atual por padrão


    // Passar todos os parâmetros de filtro para o searchModel
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id_bancos, $mes, $ano);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      'selectedYear' => $selectedYear,
      'selectedMonth' => $selectedMonth,

      'id_bancos' => $id_bancos,
      'mes' => $mes,
      'ano' => $ano,
      'selectedYear' => $selectedYear, // Passe a variável para a view
    ]);
  }
  // Ação para criar uma nova fatura
  public function actionCreate($id_bancos)
  {
    $fatura = new Faturas();
    $fatura->id_bancos = $id_bancos;
    $fatura->user_id = Yii::$app->user->id;

    if ($fatura->load(Yii::$app->request->post()) && $fatura->save()) {
      Yii::$app->session->setFlash('success', 'Fatura criada com sucesso!');
      return $this->redirect(['bancos/view', 'id' => $id_bancos]);
    }

    return $this->render('create', [
      'fatura' => $fatura,
    ]);
  }

  // Ação para atualizar uma fatura existente
  public function actionUpdate($id)
  {
    $fatura = $this->findModel($id);

    if ($fatura->load(Yii::$app->request->post()) && $fatura->save()) {
      Yii::$app->session->setFlash('success', 'Fatura atualizada com sucesso!');
      return $this->redirect(['bancos/view', 'id' => $fatura->id_bancos]);
    }

    return $this->render('update', [
      'fatura' => $fatura,
    ]);
  }
  // Ação para exibir a visão de detalhes da fatura
  public function actionView($id)
  {
    $model = $this->findModel($id);

    return $this->render('view', [
      'model' => $model,
    ]);
  }
  // Ação para deletar uma fatura
  public function actionDelete($id)
  {
    $fatura = $this->findModel($id);
    $bancoId = $fatura->id_bancos; // Armazena o ID do banco antes de excluir a fatura
    $fatura->delete();
    Yii::$app->session->setFlash('success', 'Fatura excluída com sucesso!');

    // Verifica se a requisição é AJAX
    if (Yii::$app->request->isAjax) {
      // Retorna uma resposta JSON para ser tratada pelo frontend
      return json_encode(['success' => true, 'message' => 'Fatura excluída com sucesso!']);
    }

    // Se não for uma requisição AJAX, redireciona como padrão
    return $this->redirect(['bancos/view', 'id' => $bancoId]);
  }


  // Busca o modelo de fatura com base no ID e no usuário logado
  protected function findModel($id)
  {
    if (($model = Faturas::findOne(['id_fatura' => $id, 'user_id' => Yii::$app->user->id])) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('A fatura solicitada não foi encontrada.');
  }
}