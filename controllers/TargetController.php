<?php

namespace app\controllers;

use app\models\Cashbook;
use Yii;
use app\models\Target;
use app\models\TargetSearch;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class TargetController extends BaseController
{


  // Ação para listar todas as metas
  public function actionIndex()
  {
    // Usando ActiveDataProvider para carregar as metas e paginar
    $dataProvider = new ActiveDataProvider([
      'query' => Target::find(),
      'pagination' => [
        'pageSize' => 10, // Mostra 10 metas por página
      ],
    ]);

    return $this->render('index', [
      'dataProvider' => $dataProvider,
    ]);
  }

  // Ação para criar uma nova meta
  public function actionCreate()
  {
    $model = new Target();

    // Carrega os dados do POST e salva no banco de dados
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['index']); // Redireciona para a listagem de metas
    }

    // Renderiza o formulário de criação caso o POST não seja submetido
    return $this->render('create', [
      'model' => $model,
    ]);
  }
  public function actionTarget()
  {
    $searchModel = new TargetSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('@app/views/target/index', [
      'model' => new Cashbook(),
      'dataProvider' => $dataProvider,
    ]);
  }

  // Ação para atualizar uma meta existente
  public function actionUpdate($id)
  {
    // Carrega a meta pelo ID
    $model = $this->findModel($id);

    // Se o formulário foi submetido e os dados são válidos, salva a meta
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['index']); // Redireciona para a listagem
    }

    // Renderiza o formulário de edição
    return $this->render('update', [
      'model' => $model,
    ]);
  }

  // Ação para deletar uma meta
  public function actionDelete($id)
  {
    // Deleta a meta pelo ID
    $this->findModel($id)->delete();

    // Redireciona para a listagem de metas
    return $this->redirect(['index']);
  }

  // Método auxiliar para encontrar o modelo Target baseado no ID
  protected function findModel($id)
  {
    if (($model = Target::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
  }
}
