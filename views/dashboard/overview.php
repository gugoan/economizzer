<?php

use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\data\SqlDataProvider;

$this->title = 'Economizzer';
$this->title = Yii::t('app', 'Overview');

// Exemplo de uso de SqlDataProvider para carregar transações
$dataProvider = new SqlDataProvider([
  'sql' => 'SELECT description, value, date FROM cashbook WHERE user_id = :user_id',
  'params' => [':user_id' => Yii::$app->user->id],
  'pagination' => [
    'pageSize' => 10,
  ],
]);

$balance = ((round((int)$currentmonth_revenue) - abs(round((int)$currentmonth_expense))) >= 0 ? (round((int)$currentmonth_revenue) - abs(round((int)$currentmonth_expense))) : 0);
?>

<div class="dashboard-index">
  <div class="row">
    <div class="col-md-6">
      <?php echo $this->render('_menu'); ?>
    </div>
    <div class="col-md-6"></div>
  </div>
  <hr />

  <!-- Abas -->
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#tab1"><?php echo Yii::t('app', 'Evolution '); ?></a></li>
    <li><a data-toggle="tab" href="#tab2"><?php echo Yii::t('app', 'Performance'); ?></a></li>
    <li><a data-toggle="tab" href="#tab3"><?php echo Yii::t('app', 'Expenses by Category'); ?></a></li>
    <li><a data-toggle="tab" href="#tab4"><?php echo Yii::t('app', 'Expenses by Segment'); ?></a></li>
    <li><a data-toggle="tab" href="#tab5"><?php echo Yii::t('app', 'Receitas vs Despesas'); ?></a></li>
    <li><a data-toggle="tab" href="#tab6"><?php echo Yii::t('app', 'Visão Geral Anual'); ?></a></li>

  </ul>

  <div class="tab-content">
    <div id="tab1" class="tab-pane fade in active">

      <div class="panel panel-default">
        <div class="panel-heading"><strong><?php echo Yii::t('app', 'Evolution'); ?></strong></div>
        <div class="panel-body" style="height: 250px;">
          <!-- Adicione seu conteúdo para a aba "Evolution" aqui -->
          <?php
          if (round((int)($currentmonth_revenue + ($previousmonth_revenue - abs((int)$previousmonth_expense)))) >= abs(round((int)$currentmonth_expense))) {
            $overbalance = "<div>" . Yii::t('app', 'Monthly balance') . "<h3 class=\"label label-success pull-right\">" . Yii::t('app', 'Positive') . "</h3></div>";
          } else {
            $overbalance = "<div>" . Yii::t('app', 'Monthly balance') . "<span class=\"label label-danger pull-right\">" . Yii::t('app', 'Negative') . "</span></div>";
          }
          echo $overbalance;
          ?>
          <table class="table table-bordered text-center">
            <thead>
              <tr>
                <th class="text-center"><i class="fa fa-line-chart"></i></th>
                <th class="text-center"><?php echo Yii::t('app', 'Previous Month'); ?></th>
                <th class="text-center"><?php echo Yii::t('app', 'Current Month'); ?></th>
              </tr>
            </thead>
            <tbody>
              <tr class="text-success">
                <td><?php echo Yii::t('app', 'Revenue'); ?></td>
                <td><?php echo Yii::t('app', '$') . " " . number_format((float)$previousmonth_revenue, 2); ?></td>
                <td>
                  <?php echo Yii::t('app', '$') . " " . number_format((float)($currentmonth_revenue + ($previousmonth_revenue - abs((float)$previousmonth_expense))), 2); ?>
                </td>
              </tr>
              <tr class="text-danger">
                <td><?php echo Yii::t('app', 'Expense'); ?></td>
                <td><?php echo Yii::t('app', '$') . " " . number_format(abs((float)$previousmonth_expense), 2); ?></td>
                <td><?php echo Yii::t('app', '$') . " " . number_format(abs((float)$currentmonth_expense), 2); ?></td>
              </tr>
              <tr class="text-primary">
                <td><?php echo Yii::t('app', 'Balance'); ?></td>
                <td>
                  <?php echo Yii::t('app', '$') . " " . number_format(((float)$previousmonth_revenue - abs((float)$previousmonth_expense)), 2); ?>
                </td>
                <td>
                  <?php echo Yii::t('app', '$') . " " . number_format(((float)$currentmonth_revenue + ($previousmonth_revenue - abs((float)$previousmonth_expense)) - abs((float)$currentmonth_expense)), 2); ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading"><strong><?php echo Yii::t('app', 'Evolução de Receitas e Despesas'); ?></strong>
        </div>
        <div class="panel-body">
          <?php
          // Consultar receitas e despesas ao longo do tempo
          $sqlLineChartData = "
                SELECT DATE(date) AS transaction_date, 
                       SUM(CASE WHEN value > 0 THEN value ELSE 0 END) AS total_income, 
                       SUM(CASE WHEN value < 0 THEN value ELSE 0 END) AS total_expense 
                FROM cashbook
                WHERE user_id = :user_id
                GROUP BY DATE(date)
                ORDER BY DATE(date)
            ";

          $lineChartDataProvider = new SqlDataProvider([
            'sql' => $sqlLineChartData,
            'params' => [':user_id' => Yii::$app->user->id],
            'pagination' => false,
          ]);

          $dates = [];
          $incomeValues = [];
          $expenseValues = [];

          foreach ($lineChartDataProvider->getModels() as $model) {
            $dates[] = $model['transaction_date'];
            $incomeValues[] = (float)$model['total_income'];
            $expenseValues[] = (float)$model['total_expense']; // Esse valor será negativo
          }

          echo Highcharts::widget([
            'options' => [
              'credits' => ['enabled' => false],
              'chart' => [
                'type' => 'line',
                'height' => 300,
              ],
              'title' => [
                'text' => '',
              ],
              'xAxis' => [
                'categories' => $dates,
                'title' => [
                  'text' => Yii::t('app', 'Data'),
                ],
              ],
              'yAxis' => [
                'min' => empty($expenseValues) ? 0 : min(min($expenseValues), 0),
                'title' => [
                  'text' => Yii::t('app', 'Valor (R$)'),
                ],
              ],
              'tooltip' => [
                'shared' => true,
                'useHTML' => true,
                'pointFormat' => '<span style="color:{point.color}">{series.name}: <b>R$ {point.y:.2f}</b><br/>',
              ],
              'series' => [[
                'name' => Yii::t('app', 'Receita'),
                'data' => $incomeValues,
                'color' => '#18bc9c', // Cor para receitas
              ], [
                'name' => Yii::t('app', 'Despesa'),
                'data' => $expenseValues,
                'color' => '#e74c3c', // Cor para despesas
              ]],
            ],
          ]);
          ?>
        </div>
      </div>
    </div>


    <div id="tab2" class="tab-pane fade ">
      <div class="panel panel-default">
        <div class="panel-heading"><strong><?php echo Yii::t('app', 'Receitas e Despesas Diárias'); ?></strong></div>
        <div class="panel-body">
          <?php
          // Consultar receitas e despesas diárias
          $sqlDailyTransactions = "
                SELECT DATE(date) AS transaction_date, 
                       SUM(CASE WHEN value > 0 THEN value ELSE 0 END) AS total_income, 
                       SUM(CASE WHEN value < 0 THEN value ELSE 0 END) AS total_expense 
                FROM cashbook
                WHERE user_id = :user_id
                GROUP BY DATE(date)
                ORDER BY DATE(date) DESC
                LIMIT 7  -- Últimos 7 dias
            ";

          $dailyTransactionsDataProvider = new SqlDataProvider([
            'sql' => $sqlDailyTransactions,
            'params' => [':user_id' => Yii::$app->user->id],
            'pagination' => false,
          ]);

          $dates = [];
          $incomeValues = [];
          $expenseValues = [];

          foreach ($dailyTransactionsDataProvider->getModels() as $model) {
            $dates[] = $model['transaction_date'];
            $incomeValues[] = (float)$model['total_income'];
            $expenseValues[] = (float)$model['total_expense']; // Esse valor será negativo
          }

          // Normalizando os valores para o gráfico de radar
          $maxValue = max(max($incomeValues), abs(min($expenseValues))); // Considera o máximo absoluto
          $normalizedIncomeValues = array_map(function ($v) use ($maxValue) {
            return ($v / $maxValue) * 100; // Normaliza para 0-100
          }, $incomeValues);

          $normalizedExpenseValues = array_map(function ($v) use ($maxValue) {
            return -abs(($v / $maxValue) * 100); // Normaliza para 0-100, mantendo negativo
          }, $expenseValues);

          // Combinar os valores em um único array para o gráfico
          $combinedValues = [];
          for ($i = 0; $i < count($dates); $i++) {
            $combinedValues[] = $normalizedIncomeValues[$i];
            $combinedValues[] = $normalizedExpenseValues[$i];
          }

          echo Highcharts::widget([
            'options' => [
              'credits' => ['enabled' => false],
              'chart' => [
                'type' => 'area',
                'polar' => true,
                'height' => 300,
              ],
              'title' => ['text' => ''],
              'pane' => [
                'startAngle' => 0,
                'endAngle' => 360,
                'background' => [
                  ['backgroundColor' => 'rgba(255, 255, 255, 0.9)', 'borderWidth' => 1, 'borderColor' => '#ccc'],
                ],
              ],
              'xAxis' => [
                'categories' => $dates,
                'tickmarkPlacement' => 'on',
              ],
              'yAxis' => [
                'min' => -100,
                'max' => 100,
                'title' => ['text' => 'Porcentagem'],
              ],
              'tooltip' => [
                'pointFormat' => Yii::t('app', 'Receita: {point.y:.1f}%<br>Despesa: {point.y:.1f}%'),
              ],
              'series' => [[
                'type' => 'area',
                'name' => Yii::t('app', 'Receita Diária'),
                'data' => $normalizedIncomeValues,
                'color' => '#18bc9c', // Cor para receitas
              ], [
                'type' => 'area',
                'name' => Yii::t('app', 'Despesa Diária'),
                'data' => $normalizedExpenseValues,
                'color' => '#e74c3c', // Cor para despesas
              ]],
            ],
          ]);
          ?>
        </div>
      </div>

    </div>


    <div id="tab3" class="tab-pane fade">
      <div class="panel panel-default">
        <div class="panel-heading"><strong><?php echo Yii::t('app', 'Expenses by Category'); ?></strong></div>
        <div class="panel-body">
          <?php
          // Consultar despesas por categoria sem filtrar pelo mês atual
          $sqlCategories = "
                SELECT desc_category AS cat, category.hexcolor_category as color, SUM(value) as value 
                FROM cashbook
                INNER JOIN category ON cashbook.category_id = category.id_category
                WHERE category.user_id = :user_id
                GROUP BY category.id_category
                ORDER BY value DESC
                LIMIT 10
            ";

          $categoriesDataProvider = new SqlDataProvider([
            'sql' => $sqlCategories,
            'params' => [':user_id' => Yii::$app->user->id],
            'pagination' => false,
          ]);

          $cat = [];
          $value = [];
          $color = [];

          foreach ($categoriesDataProvider->getModels() as $model) {
            $cat[] = $model['cat'];
            $value[] = (float)$model['value'];
            $color[] = $model['color'];
          }

          // Definir o mínimo do eixo Y baseado nos valores
          $minY = min($value) < 0 ? min($value) : 0; // Começar a partir do valor mínimo se for negativo

          echo Highcharts::widget([
            'options' => [
              'credits' => ['enabled' => false],
              'title' => ['text' => ''],
              'xAxis' => ['categories' => $cat],
              'yAxis' => [
                'min' => $minY, // Ajuste aqui
                'title' => ''
              ],
              'legend' => ['enabled' => false],
              'series' => [[
                'type' => 'bar',
                'colorByPoint' => true,
                'name' => Yii::t('app', 'Category'),
                'data' => $value,
                'colors' => $color,
              ]],
            ]
          ]);
          ?>
        </div>
      </div>
    </div>


    <div id="tab4" class="tab-pane fade">
      <div class="panel panel-default">
        <div class="panel-heading"><strong><?php echo Yii::t('app', 'Expenses by Segment'); ?></strong></div>
        <div class="panel-body">
          <?php
          // Consultar despesas por segmento sem filtrar pelo mês atual
          $sqlSegments = "
                        SELECT name AS segment, SUM(value) as total 
                        FROM cashbook
                        INNER JOIN segment ON cashbook.segment_id = segment.id
                        WHERE cashbook.user_id = :user_id AND type_id = 2
                        GROUP BY segment.id
                        ORDER BY total DESC
                        LIMIT 10
                    ";

          $segmentsDataProvider = new SqlDataProvider([
            'sql' => $sqlSegments,
            'params' => [':user_id' => Yii::$app->user->id],
            'pagination' => false,
          ]);

          $seg = [];
          $total = [];

          foreach ($segmentsDataProvider->getModels() as $model) {
            $seg[] = $model['segment'];
            $total[] = (float)$model['total'];
          }

          echo Highcharts::widget([
            'options' => [
              'credits' => ['enabled' => false],
              'title' => ['text' => ''],
              'xAxis' => ['categories' => $seg],
              'yAxis' => ['min' => 0, 'title' => ''],
              'legend' => ['enabled' => false],
              'series' => [[
                'type' => 'bar',
                'colorByPoint' => true,
                'name' => Yii::t('app', 'Segment'),
                'data' => $total,
              ],],
            ]
          ]);
          ?>
        </div>
      </div>
    </div>

    <div id="tab5" class="tab-pane fade">
      <div class="panel panel-default">
        <div class="panel-heading"><strong><?php echo Yii::t('app', 'Receitas vs Despesas'); ?></strong></div>
        <div class="panel-body">
          <?php
          // Consultar receitas e despesas mensais
          $sqlMonthlyData = "
                SELECT MONTH(date) AS month, 
                       SUM(CASE WHEN value > 0 THEN value ELSE 0 END) AS total_income, 
                       SUM(CASE WHEN value < 0 THEN value ELSE 0 END) AS total_expense 
                FROM cashbook
                WHERE user_id = :user_id
                GROUP BY MONTH(date)
                ORDER BY MONTH(date)
            ";

          $monthlyDataProvider = new SqlDataProvider([
            'sql' => $sqlMonthlyData,
            'params' => [':user_id' => Yii::$app->user->id],
            'pagination' => false,
          ]);

          $months = [];
          $monthlyIncome = [];
          $monthlyExpenses = [];

          // Prepare os dados para o gráfico
          foreach ($monthlyDataProvider->getModels() as $model) {
            // Adiciona o nome do mês correspondente
            $months[] = date("F", mktime(0, 0, 0, $model['month'], 10)); // Converte o número do mês para o nome
            $monthlyIncome[] = (float)$model['total_income'];
            $monthlyExpenses[] = (float)$model['total_expense']; // Mantém o valor negativo
          }

          // Verifica se há dados para evitar erros no gráfico
          if (empty($monthlyIncome)) {
            $monthlyIncome = array_fill(0, 12, 0); // Preenche com 0 se não houver dados
          }
          if (empty($monthlyExpenses)) {
            $monthlyExpenses = array_fill(0, 12, 0); // Preenche com 0 se não houver dados
          }

          // Exibir o gráfico
          echo Highcharts::widget([
            'options' => [
              'credits' => ['enabled' => false],
              'chart' => [
                'type' => 'area', // Mantemos o gráfico como área
                'height' => 400, // Ajuste a altura se necessário
              ],
              'title' => [
                'text' => Yii::t('app', 'Receitas vs Despesas Mensais'),
              ],
              'xAxis' => [
                'categories' => $months,
                'title' => ['text' => Yii::t('app', 'Meses')]
              ],
              'yAxis' => [
                'title' => ['text' => Yii::t('app', 'Valor (R$)')],
                'min' => min(min($monthlyExpenses), 0), // Início no valor negativo
                'max' => max(array_sum($monthlyIncome), 0), // Para incluir receitas
                'labels' => [
                  'format' => '{value} R$', // Formatação dos rótulos
                ],
              ],
              'tooltip' => [
                'shared' => true,
                'valuePrefix' => 'R$',
              ],
              'plotOptions' => [
                'area' => [
                  'stacking' => 'normal', // Mantemos o empilhamento normal
                  'lineColor' => '#666666',
                  'lineWidth' => 1,
                  'marker' => [
                    'lineWidth' => 1,
                    'lineColor' => '#666666'
                  ]
                ],
              ],
              'series' => [
                [
                  'name' => Yii::t('app', 'Receita'),
                  'data' => $monthlyIncome,
                  'color' => '#18bc9c',
                  'fillOpacity' => 0.5, // Opacidade para a área
                ],
                [
                  'name' => Yii::t('app', 'Despesa'),
                  'data' => array_map(function ($value) {
                    return $value;
                  }, $monthlyExpenses), // Manter valores negativos
                  'color' => '#e74c3c',
                  'fillOpacity' => 0.5, // Opacidade para a área
                ]
              ]
            ]
          ]);
          ?>
        </div>
      </div>
    </div>

    <div id="tab6" class="tab-pane fade">
      <div class="panel panel-default">
        <div class="panel-heading"><strong><?php echo Yii::t('app', 'Visão Geral Anual'); ?></strong></div>
        <div class="panel-body">
          <?php
          // Transformar despesas em valores absolutos
          $monthlyExpensesPositive = array_map(function ($value) {
            return abs($value); // Converte o valor para positivo
          }, $monthlyExpenses);

          echo Highcharts::widget([
            'options' => [
              'credits' => ['enabled' => false],
              'chart' => ['type' => 'column'],
              'title' => ['text' => Yii::t('app', 'Receitas e Despesas por Mês')],
              'xAxis' => [
                'categories' => $months,
                'title' => ['text' => Yii::t('app', 'Meses')]
              ],
              'yAxis' => [
                'min' => 0,
                'title' => ['text' => Yii::t('app', 'Valor')],
                'stackLabels' => [
                  'enabled' => true,
                  'style' => [
                    'fontWeight' => 'bold',
                    'color' => 'gray'
                  ]
                ]
              ],
              'legend' => [
                'align' => 'right',
                'x' => -30,
                'verticalAlign' => 'top',
                'y' => 25,
                'floating' => true,
                'backgroundColor' => '#ffffff',
                'borderColor' => '#CCC',
                'borderWidth' => 1,
                'shadow' => false
              ],
              'tooltip' => [
                'headerFormat' => '<b>{point.x}</b><br/>',
                'pointFormat' => '{series.name}: R${point.y}<br/>Total: R${point.stackTotal}'
              ],
              'plotOptions' => [
                'column' => [
                  'grouping' => true, // Agrupamento para colunas lado a lado
                  'dataLabels' => [
                    'enabled' => true,
                    'color' => 'white',
                    'format' => 'R${point.y}'
                  ]
                ]
              ],
              'series' => [
                [
                  'name' => Yii::t('app', 'Receitas'),
                  'data' => $monthlyIncome,
                  'color' => '#18bc9c'
                ],
                [
                  'name' => Yii::t('app', 'Despesas'),
                  'data' => $monthlyExpensesPositive, // Usando valores absolutos
                  'color' => '#e74c3c'
                ]
              ]
            ]
          ]);
          ?>
        </div>
      </div>
    </div>


  </div>
</div>