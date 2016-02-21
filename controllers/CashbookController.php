<?php

namespace app\controllers;

use Yii;
use app\models\Cashbook;
use app\models\CashbookSearch;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\base\Security;

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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionCreate()
    {
        $model = new Cashbook;
        $model->inc_datetime = date("Y-m-d H:i:s"); 
        $model->user_id = Yii::$app->user->identity->id;
        $model->date = date("Y-m-d");
 
        if ($model->load(Yii::$app->request->post())) {
            // process uploaded image file instance
            $file = $model->uploadImage();
 
            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if ($file !== false) {
                    // Create the ID folder 
                    $idfolder = Yii::$app->user->identity->id;
                    //$idfolder = str_pad($idfolder, 6, "0", STR_PAD_LEFT); // add 0000+ID
                    if(!is_dir(Yii::$app->params['uploadUrl'] . $idfolder)){
                    mkdir(Yii::$app->params['uploadUrl'] . $idfolder, 0777, true);
                    }
                    $path = $model->getImageFile();
                    $file->saveAs($path);
                }
                Yii::$app->session->setFlash("Entry-success", Yii::t("app", "Entry successfully included"));
                return $this->redirect(['index']);
            } else {
                // error in saving model
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->user_id != Yii::$app->user->id){
            throw new ErrorException(Yii::t('app', 'Forbidden to change entries of other users'));
        }
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
                Yii::$app->session->setFlash("Entry-success", Yii::t("app", "Entry updated"));
                return $this->redirect(['index']);
            } else {
                // error in saving model
            }
        }
        return $this->render('update', [
            'model'=>$model,
        ]);
    }
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->user_id != Yii::$app->user->id){
            throw new ErrorException(Yii::t('app', 'Forbidden to change entries of other users'));
        }
        // validate deletion and on failure process any exception
        // e.g. display an error message
        if ($model->delete()) {
            if (!$model->deleteImage()) {
                Yii::$app->session->setFlash("Entry-danger", 'Error deleting image');
            }
        }
        Yii::$app->session->setFlash("Entry-success", Yii::t("app", "Entry successfully deleted"));
        return $this->redirect(['index']);
    }
    public function actionTarget()
    {
        $model = new Cashbook();
        return $this->render('target', [
                'model' => $model,
            ]);
    }

    protected function findModel($id)
    {
        if (($model = Cashbook::findOne($id)) !== null && $model->user_id == Yii::$app->user->id) {
            return $model;
        } else {
            throw new NotFoundHttpException('The page you requested is not available or does not exist.');
        }
    }
}
