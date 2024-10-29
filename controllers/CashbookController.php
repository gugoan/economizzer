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

class CashbookController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['index', 'create', 'update', 'delete', 'view', 'target', 'accomplishment', 'overview', 'performance'],
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

        // Configuração de busca para todas as transações, sem filtros adicionais
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
        $model = new Cashbook();
        $model->inc_datetime = date("Y-m-d H:i:s");
        $model->user_id = Yii::$app->user->identity->id;
        $model->date = date("Y-m-d");

        if ($model->load(Yii::$app->request->post())) {
            $file = $model->uploadFile();

            if ($model->save()) {
                $this->processTransactions($model);

                // Verificação de upload de arquivo
                if ($file !== false) {
                    $idfolder = Yii::$app->user->identity->id;
                    $userUploadPath = Yii::$app->params['uploadPath'] . $idfolder;

                    if (!is_dir($userUploadPath)) {
                        mkdir($userUploadPath, 0755, true);
                    }

                    $path = $userUploadPath . '/' . $file->baseName . '.' . $file->extension;
                    $file->saveAs($path);
                }

                Yii::$app->session->setFlash("Entry-success", Yii::t("app", "Entrada incluída com sucesso"));
                return $this->redirect(['index']);
            } else {
                Yii::error("Falha ao salvar o modelo: " . json_encode($model->getErrors()), __METHOD__);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    protected function processTransactions($model)
    {
        if ($model->value < 0 && $model->type_id == 1) {
            $model->value = abs($model->value);

            if (!$model->save()) {
                Yii::$app->session->setFlash('error', 'Erro ao processar a transação ID ' . $model->id);
            }
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->user_id != Yii::$app->user->id) {
            throw new ErrorException(Yii::t('app', 'Forbidden to change entries of other users'));
        }

        $oldattachment = $model->attachment;
        $oldFileName = $model->filename;
        $model->edit_datetime = date("Y-m-d H:i:s");

        if ($model->load(Yii::$app->request->post())) {
            $file = $model->uploadFile();

            if ($file === false) {
                $model->attachment = $oldattachment;
                $model->filename = $oldFileName;
            }

            if ($model->save()) {
                if ($file !== false) {
                    $path = Yii::$app->params['uploadPath'] . '/' . $file->baseName . '.' . $file->extension;
                    $directory = dirname($path);

                    if (!is_dir($directory)) {
                        if (!@mkdir($directory, 0755, true)) {
                            throw new \RuntimeException(sprintf('Directory "%s" could not be created', $directory));
                        }
                    }

                    if (file_exists($path)) {
                        unlink($path);
                    }

                    if (!$file->saveAs($path)) {
                        Yii::$app->session->setFlash("Entry-error", Yii::t("app", "Failed to save the uploaded file."));
                        return $this->redirect(['index']);
                    }
                }

                Yii::$app->session->setFlash("Entry-success", Yii::t("app", "Entry updated"));
                return $this->redirect(['index']);
            } else {
                Yii::error("Failed to save model: " . json_encode($model->getErrors()), __METHOD__);
                Yii::$app->session->setFlash("Entry-error", Yii::t("app", "Failed to update the entry."));
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
            throw new ErrorException(Yii::t('app', 'Forbidden to change entries of other users'));
        }

        if ($model->delete()) {
            if (!$model->deleteFile()) {
                Yii::$app->session->setFlash("Entry-danger", 'Error deleting file');
            }
        }

        Yii::$app->session->setFlash("Entry-success", Yii::t("app", "Entry successfully deleted"));
        return $this->redirect(['index']);
    }

    public function actionClone($id)
    {
        $model = $this->findModel($id);
        $clone = new Cashbook;

        $clone->user_id         = $model->user_id;
        $clone->category_id     = $model->category_id;
        $clone->type_id         = $model->type_id;
        $clone->value           = $model->value;
        $clone->description     = $model->description;
        $clone->date            = $model->date;
        $clone->is_pending      = $model->is_pending;
        $clone->attachment      = $model->attachment;
        $clone->inc_datetime    = date('Y-m-d');
        $clone->edit_datetime   = date('Y-m-d');
        $clone->save();

        Yii::$app->session->setFlash("clone-success", Yii::t("app", "Entry successfully copied"));
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Cashbook::findOne($id)) !== null && $model->user_id == Yii::$app->user->id) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'You are not authorized to view this entry.'));
        }
    }
}
