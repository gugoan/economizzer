<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Cashbook;

class SiteController extends BaseController
{
    // public function init()
    // {
    //     parent::init();

    //     if(!Yii::$app->user->isGuest) {
    //         Yii::$app->language = Yii::$app->user->identity->profile->language;
    //     }
    // }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::classname(),
                'only'  => ['index','about'],
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
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
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
        return $this->render('accomplishment', ['m' => $m, 'v' => $v]);    
    }

    public function actionPerformance()
    {
        return $this->render('performance');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
