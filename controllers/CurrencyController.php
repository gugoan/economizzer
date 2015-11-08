<?php

namespace app\controllers;

use Yii;
use app\models\Currency;
use app\controllers\BaseController;
use yii\base\ErrorException;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

class CurrencyController extends BaseController
{
    public function behaviors()
    {
        return [

            'access' => [
                'class' => AccessControl::classname(),
                'only'  => ['index','create','update','delete','view'],
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new Currency();
        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel->find()->where(['user_id'=>Yii::$app->user->id]),
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Currency();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash("Currency-success", Yii::t("app", "Currency successfully created"));
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->user_id != Yii::$app->user->id){
            throw new ErrorException(Yii::t('app', 'Forbidden to change entries of other users'));
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash("Account-success", Yii::t("app", "Currency successfully updated"));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->user_id != Yii::$app->user->id){
            throw new ErrorException(Yii::t('app', 'Forbidden to change entries of other users'));
        }
        $model->delete();
        Yii::$app->session->setFlash("Account-success", Yii::t("app", "Currency successfully deleted"));
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Currency::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
