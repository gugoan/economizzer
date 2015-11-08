<?php

namespace app\controllers;

use app\models\Currency;
use Yii;
use app\models\Account;
use app\controllers\BaseController;
use yii\base\ErrorException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class AccountController extends BaseController
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
        $searchModel = new Account();
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
        $model = new Account();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash("Account-success", Yii::t("app", "Account successfully created"));
            return $this->redirect(['index']);
        } else {
            $currencyItems = Currency::find()->select(['id','name'])->where(['user_id'=>Yii::$app->user->id])->asArray()->all();
            $currencyItems = ArrayHelper::map($currencyItems,'id','name');
            return $this->render('create', [
                'model' => $model,
                'currencyItems' => $currencyItems,
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
            Yii::$app->session->setFlash("Account-success", Yii::t("app", "Account successfully updated"));
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
        Yii::$app->session->setFlash("Account-success", Yii::t("app", "Account successfully deleted"));
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Account::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
