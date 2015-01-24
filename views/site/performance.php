<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\bootstrap\Nav;
use yii\helpers\ArrayHelper;
//use app\models\CashbookSearch;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
/* @var $this yii\web\View */
$this->title = 'Economizzer';
$this->title = Yii::t('app', 'Vistão Geral');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
        <div class="col-xs-6 col-md-3">
            <?php
            echo Nav::widget([
                'items' => [
                    [
                        'label' => 'Resumo do Mês', 'active'=>true,
                        'url' => ['site/index'],
                        'options' => ['class' => 'active','role'=>'presentation'],
                        //'items' => [
                        //     ['label' => 'Semanal', 'url' => '#'],
                        //     ['label' => 'Media', 'url' => '#'],
                        //],
                    ],
                    [
                        'label' => 'Desempenho Anual',
                        'url' => ['site/index'],
                        'options' => ['class' => 'disabled'],
                    ],
                    [
                        'label' => 'Evolução',
                        'url' => ['site/index'],
                        'active' => false,
                        'options' => ['class' => 'disabled'],
                    ],
                    [
                        'label' => 'Top 5',
                        'url' => ['site/index'],
                        'active' => 'false',
                        'options' => ['class' => 'disabled'],
                    ],
                    [
                        'label' => 'Detalhamento',
                        'url' => ['site/index'],
                        'active' => 'true',
                        'options' => ['class' => 'disabled'],
                    ],
                    /*
                    [
                        'label' => 'Dropdown',
                        'items' => [
                             ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
                             '<li class="divider"></li>',
                             '<li class="dropdown-header">Dropdown Header</li>',
                             ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
                        ],
                    ],
                    */
                ],
            ]);
            ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-9">
        <h2>
          <span>Resumo do Mês</span>
        </h2>
        <hr/>
            <div class="row">
                  <div class="col-md-6">
                  <div class="panel panel-default">
                <div class="panel-heading"><strong>Receita x Despesa</strong></div>
                  <div class="panel-body">       
                  <?php
          $thisyear  = date('Y');
          $thismonth = date('m');
          // Via Query Builder
          /*
          $query = (new \yii\db\Query())->from('tb_cashbook');
          $sum = $query->sum('value');
          echo $sum."</br>";
          */
          // Via Data Access Objects
          $command = Yii::$app->db->createCommand("SELECT sum(value) FROM tb_cashbook WHERE type_id = 1 AND MONTH(date) = $thismonth AND YEAR(date) = $thisyear");
          $vtype1 = $command->queryScalar();
          //echo round((int)$vtype1);
          //echo "<br>";
          $command = Yii::$app->db->createCommand("SELECT sum(value) FROM tb_cashbook WHERE type_id = 2 AND MONTH(date) = $thismonth AND YEAR(date) = $thisyear");
          $vtype2 = $command->queryScalar();
          //echo round((int)$vtype2)*-1;

                 //$pie1 = \app\models\Cashbook::find()->select(['date, SUM(value) as total'])->where('MONTH(date) = '.$thismonth.' and type_id = 1')->groupby('MONTH(date)')->all();
                 //echo $pie11 = ArrayHelper::getValue($pie1, 'total');

                 //$pie2 = \app\models\Cashbook::find()->select(['date, SUM(value) as total'])->where('MONTH(date) = '.$thismonth.' and type_id = 2')->groupby('MONTH(date)')->all();
                 //echo $pie22 = ArrayHelper::getValue($pie2, 'total');

                   //echo $post;
                   //echo array_map('floatval', $pie1);

                echo Highcharts::widget([
                    'options' => [
                    'plotOptions ' => 'pie',
                    'credits' => ['enabled' => false],
            'chart'=> [
                'height'=> 300,
            ],
                  'title' => ['text' => ''],
                  'colors'=> ['#18bc9c','#e74c3c'],
            'tooltip'=> ['pointFormat'=> 'Percentual: <b>{point.percentage:.1f}%</b>'],
                  'plotOptions'=> [
                          'pie'=> [
                          'allowPointSelect'=> true,
                          'cursor'=> 'pointer',
                          'dataLabels'=> [
                          'enabled'=> false,
                        ],
                    'showInLegend'=> [
                      'enabled'=> true,
                    ]
                    ]
                ],
                  'series'=> [[
                    'type'=> 'pie',
                    'name'=> 'Valor',
                    'data'=> [
                        ['Receita',   round((int)$vtype1)],
                        ['Despesa',   round((int)$vtype2)*-1],
                    ]
                ]]
                   ]
                ]);
                ?></div></div></div>
                  <div class="col-md-6">
                      <div class="panel panel-default">
                    <div class="panel-heading"><strong>Maiores Despesas</strong></div>
                      <div class="panel-body">
                <?php 
                   //$searchModel = New CashbookSearch();
                   //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                      $dataProvider = new SqlDataProvider([
                      'sql' => 'SELECT category_id, value, date FROM tb_cashbook WHERE type_id=:status',
                      'params' => [':status' => 1],
                      //'totalCount' => $count,
                      /*'sort' => [
                          'attributes' => [
                              'value',
                              'name' => [
                                  'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                                  'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                                  'default' => SORT_DESC,
                                  'label' => 'Name',
                              ],
                          ],
                      ],*/
                      'pagination' => [
                          'pageSize' => 6,
                      ],
                      ]);
                ?>
                <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        //'filterModel' => $searchModel,
                        'tableOptions' => ['class'=>'table table-striped table-condensed'],
                        'summary'      =>  '',
                        'columns' => [
                           [
                              'attribute' => 'category_id',
                              'header' => '',
                              'value' => 'category.desc_category',
                           ],
                           [
                              'attribute' => 'value',
                              'header' => '',
                              'value' => 'value',
                           ]
                        ],
                    ]); ?>
                    </div>
                    </div>
                  </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading"><strong>Maiores Despesas</strong></div>
              <div class="panel-body">
              <?php
                  $thismonth = date('m');
                  //echo $thismonth;
                 $items1 = \app\models\Cashbook::find()->select(['date, SUM(value) as total'])->where('MONTH(date) = '.$thismonth.' and type_id = 1')->groupby('date')->asArray()->all();
                 $type1 = ArrayHelper::getColumn($items1, 'total');
                 //array_column($records, 'first_name');
                //array_filter($type1, 'is_numeric');
                //var_dump(array_column($items, 'value'));

                $items2 = \app\models\Cashbook::find()->select(['date, SUM(value) as total'])->where('MONTH(date) = '.$thismonth.' and type_id = 2')->groupby('date')->asArray()->all();
                 $type2 = ArrayHelper::getColumn($items2, 'total');
                 $date = ArrayHelper::getColumn($items2, 'date');
                 //array_column($records, 'first_name');
                //array_filter($type1, 'is_numeric ');
                //var_dump(array_column($items, 'value'));
                 
                 /*
                  $data = [
                    ['id' => 123, 'data' => 'abc'],
                    ['id' => 345, 'data' => 'def'],
                    ['id' => 345, 'data' => 'def'],
                ];
                $ids = ArrayHelper::getColumn($data, 'id');
                var_dump($ids);
                */

                // https://github.com/miloschuman/yii2-highcharts
                echo Highcharts::widget([
                   'options' => [
                   'credits' => ['enabled' => false],
                      'title' => ['text' => ''],
                      'xAxis' => [
                         'categories' => $date,
                      ],
                      'yAxis' => [
                         'title' => ['text' => 'Valor']
                      ],
                      'series' => [
                         [
                         'name' => 'Receita',
                          'color' => '#18bc9c',
                         'data' => array_map('floatval', $type1),
                         ],
                         [
                         'name' => 'Despesa',
                         'color' => '#e74c3c',
                         //'dashStyle' => 'ShortDash',
                         'data' => array_map('floatval', $type2),
                         ]
                      ]
                   ]
                ]);
                ?>
                </div>
                <div class="panel panel-default">
                <div class="panel-heading"><strong>Grafico de exemplo</strong></div>
                  <div class="panel-body">
                <?php
                echo Highcharts::widget([

    'options' => [
        'credits' => ['enabled' => false],
        'title' => [
            'text' => '',
        ],
        'xAxis' => [
            'categories' => ['Apples', 'Oranges', 'Pears', 'Bananas', 'Plu ms '],
        ],
        'labels' => [
            'items' => [
                [
                    'html' => 'Receita x Despesa',
                    'style' => [
                        'left' => '50px',
                        'top' => '18px',
                        'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                    ],
                ],
            ],
        ],
        'series' => [
            [
                'type' => 'column',
                'name' => 'Jane',
                'data' => [3, 2, 1, 3, 4],
            ],
            [
                'type' => 'column',
                'name' => 'John',
                'data' => [2, 3, 5, 7, 6],
            ],
            [
                'type' => 'column',
                'name' => 'Joe',
                'data' => [4, 3, 3, 9, 0],
            ],
            [
                'type' => 'spline',
                'name' => 'Average',
                'data' => [3, 2.67, 3, 6.33, 3.33],
                 'marker' => [
                    'lineWidth' => 2,
                    'lineColor' => new JsExpression('Highcharts.getOptions().colors[3]'),
                    'fillColor' => 'white',
                ],
            ],
            [
                'type' => 'pie',
                'name' => 'Total',
                'data' => [
                    [
                        'name' => 'Receita',
                        'y' => 13,
                        'color' => '#18bc9c',
                    ],
                    [
                        'name' => 'Despesa',
                        'y' => 23,
                        'color' => '#e74c3c',
                    ],
                ],
                'center' => [100, 80],
                'size' => 100,
                'showInLegend' => false,
                'dataLabels' => [
                    'enabled' => false,
                ],
            ],
        ],
    ]
]);
                ?>
                  </div>
                </div>
            </div>
        </div>
 </div>