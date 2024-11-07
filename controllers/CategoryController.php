<?php

namespace app\controllers;

use Yii;
use app\models\Category;
use app\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

class CategoryController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::classname(),
                'only'  => ['index', 'create', 'update', 'delete', 'view'],
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

    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Category();
        $model->user_id = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post())) {
            // Verifica e aplica as regras de categorização automáticas, se existir
            if (!empty($model->regras_auto_categorizacao)) {
                $model->regras_auto_categorizacao = json_encode($model->regras_auto_categorizacao);
            } else {
                $model->regras_auto_categorizacao = null;
            }
            

            if ($model->save()) {
                // Adiciona histórico de alterações
                $model->historico_alteracoes = 'Categoria criada em: ' . date('Y-m-d H:i:s') . ' por ' . Yii::$app->user->identity->username;
                $model->save(false, ['historico_alteracoes']);

                Yii::$app->session->setFlash("Category-success", Yii::t("app", "Category successfully included"));
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->user_id != Yii::$app->user->id) {
            throw new \yii\web\ForbiddenHttpException(Yii::t('app', 'Forbidden to change entries of other users'));
        }

        if ($model->load(Yii::$app->request->post())) {
            // Atualiza o histórico de alterações
            $historicoAtual = $model->historico_alteracoes;
            $novoHistorico = 'Atualizado em: ' . date('Y-m-d H:i:s') . ' por ' . Yii::$app->user->identity->username;
            $model->historico_alteracoes = $historicoAtual . "\n" . $novoHistorico;

            if ($model->save()) {
                Yii::$app->session->setFlash("Category-success", Yii::t("app", "Category updated"));
                return $this->redirect(['view', 'id' => $model->id_category]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->user_id != Yii::$app->user->id) {
            throw new \yii\web\ForbiddenHttpException(Yii::t('app', 'Forbidden to change entries of other users'));
        }
        try {
            $model->delete();
            Yii::$app->session->setFlash("Category-success", Yii::t("app", "Category successfully deleted"));
            return $this->redirect(['index']);
        } catch (\yii\db\IntegrityException $e) {
            Yii::$app->session->setFlash("Category-danger", Yii::t("app", "This category is associated with some record"));
            return $this->redirect(['index']);
        }
    }

    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null && $model->user_id == Yii::$app->user->id) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t("app", "The page you requested is not available or does not exist."));
        }
    }
}