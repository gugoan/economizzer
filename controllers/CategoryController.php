<?php

namespace app\controllers;

use Yii;
use app\models\Category;
use app\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class CategoryController extends BaseController
{
    // public function init()
    // {
    //     parent::init();

    //     // if(!Yii::$app->user->isGuest) {
    //     //   Yii::$app->user->getIdentity()->language = Yii::$app->language;
    //     // }
    // }
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash("Category-success", Yii::t("app", "Category successfully included"));
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash("Category-success", Yii::t("app", "Category updated"));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $model= $this->findModel($id);
        try {
             $model->delete();
             Yii::$app->session->setFlash("Category-success", Yii::t("app", "Category successfully deleted"));
             return $this->redirect(['index']);
        } catch(\yii\db\IntegrityException $e) {
             //throw new \yii\web\ForbiddenHttpException('Could not delete this record.');
             Yii::$app->session->setFlash("Category-error", Yii::t("app", "This category is associated with some record"));
             return $this->redirect(['index']);            
        }        
    }

    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null && $model->user_id == Yii::$app->user->id) {
            return $model;
        } else {
            throw new NotFoundHttpException('The page you requested is not available or does not exist.');
        }
    }
}
