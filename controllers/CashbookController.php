<?php

namespace app\controllers;

use Yii;
use app\models\Cashbook;
use app\models\CashbookSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\base\Security;

/**
 * CashbookController implements the CRUD actions for Cashbook model.
 */
class CashbookController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::classname(),
                'only'  => ['index','create','update','delete','view','target','accomplishment','overview','performance'],
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

    /**
     * Lists all Cashbook models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CashbookSearch();
        $searchModel->start_date = date('Y-m-01'); // get start date 
        $searchModel->end_date = date("Y-m-t");; // get end date
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cashbook model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cashbook model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cashbook;
        $model->inc_datetime = date("Y-m-d H:i:s"); 
        $model->user_id = Yii::$app->user->identity->id;       
 
        if ($model->load(Yii::$app->request->post())) {
            // process uploaded image file instance
            $file = $model->uploadImage();
 
            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if ($file !== false) {
                    $path = $model->getImageFile();
                    $file->saveAs($path);
                }
                return $this->redirect(['view', 'id'=>$model->id]);
            } else {
                // error in saving model
            }
        }
        return $this->render('create', [
            'model'=>$model,
        ]);
    }

    /**
     * Updates an existing Cashbook model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldFile = $model->getImageFile();
        $oldattachment = $model->attachment;
        $oldFileName = $model->filename;
        $model->edit_datetime = date("Y-m-d H:i:s");
 
        if ($model->load(Yii::$app->request->post())) {
            // process uploaded image file instance
            $file = $model->uploadImage();
 
            // revert back if no valid file instance uploaded
            if ($file === false) {
                $model->attachment = $oldattachment;
                $model->filename = $oldFileName;
            }
 
            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if ($file !== false && unlink($oldFile)) { // delete old and overwrite
                    $path = $model->getImageFile();
                    $file->saveAs($path);
                }
                return $this->redirect(['view', 'id'=>$model->id]);
            } else {
                // error in saving model
            }
        }
        return $this->render('update', [
            'model'=>$model,
        ]);
    }

    /**
     * Deletes an existing Cashbook model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
 
        // validate deletion and on failure process any exception
        // e.g. display an error message
        if ($model->delete()) {
            if (!$model->deleteImage()) {
                Yii::$app->session->setFlash('error', 'Error deleting image');
            }
        }
        return $this->redirect(['index']);
    }

     /**
     * User targets Cashbook model.
     * 
     * @param integer $id
     * @return mixed
     */
    public function actionTarget()
    {
        $model = new Cashbook();
        return $this->render('target', [
                'model' => $model,
            ]);
    }
    public function actionOverview()
    {
        $model = new Cashbook();
        return $this->render('overview', [
                'model' => $model,
            ]);
    }
    public function actionAccomplishment()
    {
        $model = new Cashbook();
        $thisyear  = date('Y');
        $thismonth = date('m');
        $user    = Yii::$app->user->identity->id;
        $command = Yii::$app->db->createCommand("SELECT SUM(value) as v, MONTH(date) as m FROM tb_cashbook WHERE YEAR(date) = $thisyear AND user_id = $user AND category_id = 18 GROUP BY MONTH(date) ORDER BY MONTH(date) asc;");
        $accomplishment = $command->queryAll();
        
        $m = array();
        $v = array();
 
        for ($i = 0; $i < sizeof($accomplishment); $i++) {
           $m[] = $accomplishment[$i]["m"];
           $v[] = (int) $accomplishment[$i]["v"];
        }
        return $this->render('accomplishment', [
            'model'=>$model,
            'm' => $m, 
            'v' => $v,
            ]);    
    }
    public function actionPerformance()
    {
        $model = new Cashbook();
        return $this->render('performance', [
                'model' => $model,
            ]);
    }

    /**
     * Finds the Cashbook model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cashbook the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cashbook::findOne($id)) !== null && $model->user_id == Yii::$app->user->id) {
            return $model;
        } else {
            throw new NotFoundHttpException('The page you requested is not available or does not exist.');
        }
    }
}
