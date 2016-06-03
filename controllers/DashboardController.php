<?php

namespace app\controllers;

use Yii;
use app\models\Dashboard;
use app\models\DashboardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\Security;


class DashboardController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::classname(),
                'only'  => ['index','accomplishment','overview','performance'],
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
        $searchModel = new DashboardSearch();
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
        $model = new Dashboard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionOverview()
    {
        $model = new Dashboard();

        $thisyear  = date('Y');
        $thismonth = date('m');
        $lastmonth = date('m', strtotime('-1 months', strtotime(date('Y-m-d'))));        
        $user    = Yii::$app->user->identity->id;        

        $command = Yii::$app->db->createCommand("SELECT sum(value) FROM cashbook WHERE user_id = $user AND type_id = 1 AND MONTH(date) = $thismonth AND YEAR(date) = $thisyear");
        $vtype1 = $command->queryScalar();

        $command = Yii::$app->db->createCommand("SELECT sum(value) FROM cashbook WHERE user_id = $user AND type_id = 2 AND MONTH(date) = $thismonth AND YEAR(date) = $thisyear");
        $vtype2 = $command->queryScalar();

        $lastmonth_command = Yii::$app->db->createCommand("SELECT sum(value) FROM cashbook WHERE user_id = $user AND type_id = 1 AND MONTH(date) = $lastmonth AND YEAR(date) = $thisyear");
        $lastmonth_type1 = $lastmonth_command->queryScalar();

        $lastmonth_command = Yii::$app->db->createCommand("SELECT sum(value) FROM cashbook WHERE user_id = $user AND type_id = 2 AND MONTH(date) = $lastmonth AND YEAR(date) = $thisyear");
        $lastmonth_type2 = $lastmonth_command->queryScalar();

        $category_cmd = Yii::$app->db->createCommand(
            "SELECT desc_category AS cat, category.hexcolor_category as color, SUM(value) as value FROM cashbook
            INNER JOIN category
            ON cashbook.category_id = category.id_category
            WHERE category.user_id = $user AND type_id = 2 AND MONTH(date) = $thismonth AND YEAR(date) = $thisyear
            GROUP BY category.id_category
            ");
        $category = $category_cmd->queryAll();
        
        $cat = array();
        $color = array();
        $value = array();
 
        for ($i = 0; $i < sizeof($category); $i++) {
           $cat[] = $category[$i]["cat"];
           $color[] = ($category[$i]["color"] <> '' ? $category[$i]["color"] : '#2C3E50');
           $value[] = abs((int) $category[$i]["value"]); //turn value into positive number for chart gen
        }        

        return $this->render('overview', [
            'model'=>$model,
            'vtype1' => $vtype1, 
            'vtype2' => $vtype2,
            'lastmonth_type1' => $lastmonth_type1, 
            'lastmonth_type2' => $lastmonth_type2, 
            'cat' => $cat,
            'color' => $color,
            'value' => $value,                       
            ]);  
    }    

    public function actionAccomplishment()
    {
        $model = new Dashboard();

        $url = Yii::$app->getRequest()->getQueryParam('category_id');
        $category_id = isset($url) ? $url : 0;
        //$category_id = $model->category_id;
        $thisyear  = date('Y');
        $thismonth = date('m');
        $user    = Yii::$app->user->identity->id;

        $command = Yii::$app->db->createCommand("SELECT 
            desc_category as n, SUM(value) as v, MONTHNAME(date) as m 
            FROM cashbook 
            INNER JOIN category
            on category.id_category = cashbook.category_id
            WHERE YEAR(date) = $thisyear AND cashbook.user_id = $user AND category_id = $category_id 
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
        //      SUM(IF(cashbook.type_id=1, value, 0)) as v1,
        //      SUM(IF(cashbook.type_id=2, value, 0)) as v2,
        //      MONTHNAME(date) as m 
        //      FROM cashbook WHERE user_id = 3 AND YEAR(date) = 2015 GROUP BY m DESC
        $model = new Dashboard();
        
        $thisyear  = date('Y');
        $thismonth = date('m');
        $lastmonth = date('m', strtotime('-1 months', strtotime(date('Y-m-d'))));
        $user      = Yii::$app->user->identity->id;

        $command = Yii::$app->db->createCommand("SELECT 
            SUM(IF(cashbook.type_id=1, value, 0)) as v1,
            SUM(IF(cashbook.type_id=2, value, 0)) as v2,
            MONTHNAME(date) as m 
            FROM cashbook WHERE user_id = $user AND YEAR(date) = $thisyear GROUP BY m ORDER BY MONTH(date)");
        $performance = $command->queryAll();
        
        $m = array();
        $v1 = array();
        $v2 = array();
 
        for ($i = 0; $i < sizeof($performance); $i++) {
           $m[] = $performance[$i]["m"];
           $v1[] = (int) $performance[$i]["v1"];
           $v2[] = abs((int) $performance[$i]["v2"]);
        }
        return $this->render('performance', [
            'model'=>$model,
            'm' => $m, 
            'v1' => $v1,
            'v2' => $v2,
            ]); 
    }      

    protected function findModel($id)
    {
        if (($model = Dashboard::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
