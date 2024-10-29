<?php

namespace app\controllers;

use Yii;
use app\models\Dashboard;
use app\models\DashboardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class DashboardController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::classname(),
                'only'  => ['index', 'accomplishment', 'overview', 'performance'],
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
        $lastmonth = date("m", mktime(0, 0, 0, date("m") - 1, 1, date("Y")));
        $user    = Yii::$app->user->identity->id;

        // Obtenção de receitas e despesas do mês atual e do mês anterior
        $currentmonth_revenue = $this->getMonthlySum($user, 1, $thismonth, $thisyear);
        $currentmonth_expense = $this->getMonthlySum($user, 2, $thismonth, $thisyear);
        $lastmonth_revenue = $this->getMonthlySum($user, 1, $lastmonth, $thisyear);
        $previousmonth_expense = $this->getMonthlySum($user, 2, $lastmonth, $thisyear);
        $balance = $this->getBalance($user);

        // Categorias de despesas do mês atual
        $category = $this->getExpenseCategories($user, $thismonth, $thisyear);
        [$cat, $color, $value] = $this->prepareCategoryData($category);

        // Segmentação de despesas
        $segment = $this->getExpenseSegments($user);
        [$seg, $colorseg, $total] = $this->prepareSegmentData($segment);

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $userId = Yii::$app->user->id; // Assumindo que o ID do usuário está na sessão
        $year = date('Y'); // Ano atual
        $incomeTypeId = 1; // Defina o ID correto para o tipo de receita
        $monthlyIncome = [];
        $monthlyExpenses = []; // Supondo que você também queira as despesas mensais

        // Loop pelos 12 meses para coletar os dados de receita e despesa
        for ($month = 1; $month <= 12; $month++) {
            $monthlyIncome[] = $this->getMonthlySum($userId, $incomeTypeId, $month, $year) ?? 0;
            $monthlyExpenses[] = $this->getMonthlySum($userId, 2, $month, $year) ?? 0; // Substitua '2' pelo ID correto para despesas
        }

        return $this->render('overview', [
            'monthlyIncome' => $monthlyIncome, // Certifique-se de que esta linha existe
            'monthlyExpenses' => $monthlyExpenses,
            'months' => $months,
            'model' => $model,
            'currentmonth_revenue' => $currentmonth_revenue,
            'currentmonth_expense' => $currentmonth_expense,
            'previousmonth_revenue' => $balance + $lastmonth_revenue,
            'previousmonth_expense' => $previousmonth_expense,
            'cat' => $cat,
            'color' => $color,
            'value' => $value,
            'seg' => $seg,
            'total' => $total,
            'colorseg' => $colorseg,
        ]);
    }

    private function getMonthlySum($user, $typeId, $month, $year)
    {
        return Yii::$app->db->createCommand("SELECT SUM(value) FROM cashbook WHERE user_id = :user AND type_id = :typeId AND MONTH(date) = :month AND YEAR(date) = :year")
            ->bindValues([':user' => $user, ':typeId' => $typeId, ':month' => $month, ':year' => $year])
            ->queryScalar();
    }

    private function getBalance($user)
    {
        $lastmonth = date("m", mktime(0, 0, 0, date("m") - 1, 1, date("Y")));
        $all_revenue = Yii::$app->db->createCommand("SELECT SUM(value) FROM cashbook WHERE user_id = :user AND type_id = 1 AND MONTH(date) < :lastmonth")
            ->bindValues([':user' => $user, ':lastmonth' => $lastmonth])
            ->queryScalar();
        $all_expense = Yii::$app->db->createCommand("SELECT SUM(value) FROM cashbook WHERE user_id = :user AND type_id = 2 AND MONTH(date) < :lastmonth")
            ->bindValues([':user' => $user, ':lastmonth' => $lastmonth])
            ->queryScalar();

        return $all_revenue - $all_expense; // Ajuste a fórmula de cálculo do saldo se necessário
    }

    private function getExpenseCategories($user, $month, $year)
    {
        return Yii::$app->db->createCommand("
            SELECT desc_category AS cat, category.hexcolor_category AS color, SUM(value) AS value 
            FROM cashbook
            INNER JOIN category ON cashbook.category_id = category.id_category
            WHERE category.user_id = :user AND type_id = 2 AND MONTH(date) = :month AND YEAR(date) = :year
            GROUP BY category.id_category
            ORDER BY value ASC LIMIT 10
        ")
            ->bindValues([':user' => $user, ':month' => $month, ':year' => $year])
            ->queryAll();
    }

    private function prepareCategoryData($category)
    {
        $cat = $color = $value = [];

        foreach ($category as $item) {
            $cat[] = $item["cat"];
            $color[] = !empty($item["color"]) ? $item["color"] : '#2C3E50';
            $value[] = abs((int) $item["value"]); // Converte valor para número positivo para gerar o gráfico
        }

        return [$cat, $color, $value];
    }

    private function getExpenseSegments($user)
    {
        return Yii::$app->db->createCommand("
            SELECT x.`year`, x.`month`, y.desc_category AS seg, y.hexcolor_category AS colorseg, SUM(x.value) AS total 
            FROM (
                SELECT category.id_category, category.desc_category, category.parent_id, c.value AS value, 
                       YEAR(c.`date`) AS `year`, MONTH(c.`date`) AS `month`
                FROM category
                INNER JOIN cashbook AS c ON category.id_category = c.category_id 
            ) AS x 
            INNER JOIN category AS y ON x.parent_id = y.id_category
            INNER JOIN user AS u ON y.user_id = u.id
            WHERE u.id = :user
            GROUP BY x.`year`, x.`month`, y.desc_category, y.hexcolor_category
            HAVING x.`year` = YEAR(NOW()) AND x.`month` = MONTH(NOW())
        ")
            ->bindValues([':user' => $user])
            ->queryAll();
    }

    private function prepareSegmentData($segment)
    {
        $seg = $colorseg = $total = [];

        foreach ($segment as $item) {
            $seg[] = $item["seg"];
            $colorseg[] = !empty($item["colorseg"]) ? $item["colorseg"] : '#2C3E50';
            $total[] = abs((int) $item["total"]);
        }

        return [$seg, $colorseg, $total];
    }

    public function actionAccomplishment()
    {
        $model = new Dashboard();

        $url = Yii::$app->getRequest()->getQueryParam('category_id');
        $category_id = isset($url) ? $url : 0;
        $thisyear  = date('Y');
        $thismonth = date('m');
        $user    = Yii::$app->user->identity->id;

        $command = Yii::$app->db->createCommand("
            SELECT 
            desc_category as n, MONTHNAME(date) as m, SUM(value) as v 
            FROM cashbook 
            INNER JOIN category
            on category.id_category = cashbook.category_id
            WHERE YEAR(date) = $thisyear AND cashbook.user_id = $user AND category_id = $category_id 
            GROUP BY desc_category, MONTHNAME(date) 
            ORDER BY desc_category ASC, MONTHNAME(date) asc;");
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
            'model' => $model,
            'm' => $m,
            'v' => $v,
            'n' => $n,
            'category_id' => $category_id,
        ]);
    }

    public function actionPerformance()
    {
        $model = new Dashboard();

        $thisyear  = date('Y');
        $thismonth = date('m');
        $lastmonth = date("m", mktime(0, 0, 0, date("m") - 1, 1, date("Y")));
        $user      = Yii::$app->user->identity->id;

        $command = Yii::$app->db->createCommand("SELECT 
            SUM(IF(cashbook.type_id=1, value, 0)) as v1,
            SUM(IF(cashbook.type_id=2, value, 0)) as v2,
            MONTHNAME(date) as m 
            FROM cashbook 
            WHERE user_id = $user AND YEAR(date) = $thisyear 
            GROUP BY MONTHNAME(date) 
            ORDER BY MONTHNAME(date)");
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
            'model' => $model,
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
