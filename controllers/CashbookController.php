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
            'model'=>$model,
        ]);
    }
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
                Yii::$app->session->setFlash("Entry-success", Yii::t("app", "Entry updated"));
                return $this->redirect(['view', 'id'=>$model->id]);
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
        // validate deletion and on failure process any exception
        // e.g. display an error message
        if ($model->delete()) {
            if (!$model->deleteImage()) {
                Yii::$app->session->setFlash('error', 'Error deleting image');
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
    public function actionOverview()
    {
        $model = new Cashbook();

        $thisyear  = date('Y');
        $thismonth = date('m');
        $lastmonth = date('m', strtotime('-1 months', strtotime(date('Y-m-d'))));        
        $user    = Yii::$app->user->identity->id;        

        $command = Yii::$app->db->createCommand("SELECT sum(value) FROM tb_cashbook WHERE user_id = $user AND type_id = 1 AND MONTH(date) = $thismonth AND YEAR(date) = $thisyear");
        $vtype1 = $command->queryScalar();

        $command = Yii::$app->db->createCommand("SELECT sum(value) FROM tb_cashbook WHERE user_id = $user AND type_id = 2 AND MONTH(date) = $thismonth AND YEAR(date) = $thisyear");
        $vtype2 = $command->queryScalar();

        // get last month values;
        $lastmonth_command = Yii::$app->db->createCommand("SELECT sum(value) FROM tb_cashbook WHERE user_id = $user AND type_id = 1 AND MONTH(date) = $lastmonth AND YEAR(date) = $thisyear");
        $lastmonth_type1 = $lastmonth_command->queryScalar();

        $lastmonth_command = Yii::$app->db->createCommand("SELECT sum(value) FROM tb_cashbook WHERE user_id = $user AND type_id = 2 AND MONTH(date) = $lastmonth AND YEAR(date) = $thisyear");
        $lastmonth_type2 = $lastmonth_command->queryScalar();

        return $this->render('overview', [
            'model'=>$model,
            'vtype1' => $vtype1, 
            'vtype2' => $vtype2,
            'lastmonth_type1' => $lastmonth_type1, 
            'lastmonth_type2' => $lastmonth_type2,            
            ]);  
    }  
    public function actionAccomplishment()
    {
        $model = new Cashbook();

        $url = Yii::$app->getRequest()->getQueryParam('category_id');
        $category_id = isset($url) ? $url : 0;
        //$category_id = $model->category_id;
        $thisyear  = date('Y');
        $thismonth = date('m');
        $user    = Yii::$app->user->identity->id;

        $command = Yii::$app->db->createCommand("SELECT 
            desc_category as n, SUM(value) as v, MONTHNAME(date) as m 
            FROM tb_cashbook 
            INNER JOIN tb_category
            on tb_category.id_category = tb_cashbook.category_id
            WHERE YEAR(date) = $thisyear AND tb_cashbook.user_id = $user AND category_id = $category_id 
            GROUP BY MONTH(date) 
            ORDER BY MONTH(date) asc;");
        $accomplishment = $command->queryAll();
        
        $m = array();
        $v = array();
        $n = array();
 
        for ($i = 0; $i < sizeof($accomplishment); $i++) {
           $m[] = $accomplishment[$i]["m"];
           $v[] = abs((int) $accomplishment[$i]["v"]); //turn value into positive number for chart gen
           $n = $accomplishment[$i]["n"];
        }
        return $this->render('accomplishment', [
            'model'=>$model,
            'm' => $m, 
            'v' => $v,
            'n' => $n,
            'category_id' => $category_id,
            ]);    
    }
    public function actionPerformance()
    {

        //      SELECT  
        //      SUM(IF(tb_cashbook.type_id=1, value, 0)) as v1,
        //      SUM(IF(tb_cashbook.type_id=2, value, 0)) as v2,
        //      MONTHNAME(date) as m 
        //      FROM tb_cashbook WHERE user_id = 3 AND YEAR(date) = 2015 GROUP BY m DESC
        $model = new Cashbook();
        
        $thisyear  = date('Y');
        $thismonth = date('m');
        $lastmonth = date('m', strtotime('-1 months', strtotime(date('Y-m-d'))));
        $user      = Yii::$app->user->identity->id;

        $command = Yii::$app->db->createCommand("SELECT 
            SUM(IF(tb_cashbook.type_id=1, value, 0)) as v1,
            SUM(IF(tb_cashbook.type_id=2, value, 0)) as v2,
            MONTHNAME(date) as m 
            FROM tb_cashbook WHERE user_id = $user AND YEAR(date) = $thisyear GROUP BY m ORDER BY MONTH(date)");
        $performance = $command->queryAll();
        
        $m = array();
        $v1 = array();
        $v2 = array();
 
        for ($i = 0; $i < sizeof($performance); $i++) {
           $m[] = $performance[$i]["m"];
           $v1[] = (int) $performance[$i]["v1"];
           $v2[] = (int) $performance[$i]["v2"];
        }
        return $this->render('performance', [
            'model'=>$model,
            'm' => $m, 
            'v1' => $v1,
            'v2' => $v2,
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
