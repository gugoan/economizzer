<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\bootstrap\Nav;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
/* @var $this yii\web\View */
$this->title = 'Economizzer';
$this->title = Yii::t('app', 'Vistão Geral');
$this->params['breadcrumbs'][] = $this->title;


$thisyear  = date('Y');
$thismonth = date('m');
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
          <span>Resumo do Mês <small><?php echo $thismonth."/".$thisyear ?></small></span>
        </h2>
        <hr/>
            <div class="row">
                  <div class="col-md-6">
                  <div class="panel panel-default">
                <div class="panel-heading"><strong>Receita x Despesa</strong></div>
                  <div class="panel-body">       
                  <?php
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
          //echo abs(round((int)$vtype2));

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
                        ['Despesa',   abs(round((int)$vtype2))],
                    ]
                ]]
                   ]
                ]);
                ?></div></div></div>
                  <div class="col-md-6">
                      <div class="panel panel-default">
                    <div class="panel-heading"><strong>Desempenho</strong></div>
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
                <h4>Seu saldo do mês está: <span class="label label-danger">Negativo</span></h4>
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
            
            </div>
        </div>
 </div>