<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use app\models\Cashbook;

$this->title = 'Economizzer';
$this->title = Yii::t('app', 'Overview');
?>
<div class="dashboard-index">
      <div class="row">
        <div class="col-md-6"><?php  echo $this->render('_menu'); ?></div>
        <div class="col-md-6"></div>
      </div>
      <hr/>
      <div class="row">
            <div class="col-md-6">
            <div class="panel panel-default">
          <div class="panel-heading"><strong><?php echo Yii::t('app', 'Performance');?></strong></div>
            <div class="panel-body" style="height: 250px;">
            <?php
            $balance = ((round((int)$vtype1)-abs(round((int)$vtype2))) >=0 ? (round((int)$vtype1)-abs(round((int)$vtype2))) : 0);
            echo Highcharts::widget([
                'options' => [
                    'credits' => ['enabled' => false],
                    'chart'=> [
                    'height'=> 200,
                    ],
                    'title' => [
                        'text' => Yii::t('app', 'Expense'),
                        'align' => 'center',
                        'verticalAlign' => 'middle',
                          'style' => [
                              'fontSize'=> '12px',
                              'color' => '#e74c3c',
                          ] 
                        ],
                    //'colors'=> ['#18bc9c','#e74c3c'],
                    'colors'=> ['#cccccc','#e74c3c'],
                    'tooltip'=> ['pointFormat'=> Yii::t('app', 'Percentage').': <b>{point.percentage:.1f}%</b>'],
                    'plotOptions'=> [
                        'pie'=> [
                            'allowPointSelect'=> true,
                            'cursor'=> 'pointer',
                            'size'=> '100%',
                            'innerSize'=> '60%',
                            'dataLabels'=> [
                                'enabled'=> false,
                            ],
                            'center'=> ['50%', '55%'],
                        ]
                    ],
                    'series'=> [[
                        'type'=> 'pie',
                        'name'=> 'Valor',
                        'data'=> [
                            [Yii::t('app', 'Balance'),   $balance],
                            [Yii::t('app', 'Expense'),   abs(round((int)$vtype2))],
                        ]
                    ]]
                ]
                ]);
                ?>
            </div></div></div>
            <div class="col-md-6">
                <div class="panel panel-default">
              <div class="panel-heading"><strong><?php echo Yii::t('app', 'Evolution');?></strong></div>
              <div class="panel-body" style="height: 250px;">
              <?php 
              // get overbalance
              if(round((int)$vtype1) >= abs(round((int)$vtype2)))
              {
                $overbalance = "<div>". Yii::t('app', 'Monthly balance'). "<h3 class=\"label label-success pull-right\">".Yii::t('app', 'Positive')."</h3></div>";
              }else{
                $overbalance = "<div>". Yii::t('app', 'Monthly balance'). "<span class=\"label label-danger pull-right\">".Yii::t('app', 'Negative')."</span></div>";
              }
              echo $overbalance;
              ?>

              <table class="table table-bordered text-center">
                  <thead>
                      <tr>
                          <th class="text-center"><i class="fa fa-line-chart"></i></th>
                          <th class="text-center"><?php echo Yii::t('app', 'Previous Month');?></th>
                          <th class="text-center"><?php echo Yii::t('app', 'Current Month');?></th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr class="text-success">
                          <td><?php echo Yii::t('app', 'Revenue');?></td>
                          <td><?php echo Yii::t('app', '$')." ".(int)$lastmonth_type1;?></td>
                          <td><?php echo Yii::t('app', '$')." ".(int)$vtype1;?></td>
                      </tr>
                      <tr class="text-danger">
                          <td><?php echo Yii::t('app', 'Expense');?></td>
                          <td><?php echo Yii::t('app', '$')." ".abs((int)$lastmonth_type2);?></td>
                          <td><?php echo Yii::t('app', '$')." ".abs((int)$vtype2);?></td>
                      </tr>
                      <tr class="text-primary">
                          <td><?php echo Yii::t('app', 'Balance');?></td>
                          <td><?php echo Yii::t('app', '$')." ".((int)$lastmonth_type1 - abs((int)$lastmonth_type2));?></td>
                          <td><?php echo Yii::t('app', '$')." ".((int)$vtype1 - abs((int)$vtype2));?></td>
                      </tr>
                  </tbody>
              </table>
              </div>
              </div>
            </div>
      </div>
            <div class="row">
                <div class="col-md-6">
                  <div class="panel panel-default">
                    <div class="panel-heading"><strong><?php echo Yii::t('app', 'Expenses by Category');?></strong></div>
                    <div class="panel-body">
                      <?php 
                      echo Highcharts::widget([
                      'options' => [
                          'credits' => ['enabled' => false],
                          'title' => [
                              'text' => '',
                          ],
                          'xAxis' => [
                              'categories' => $cat,
                          ],
                          'yAxis' => [
                              'min' => 0,
                              'title' => '',
                          ],                        
                          'series' => [
                              [
                                  'type' => 'bar',
                                  'colorByPoint'=> true,
                                  'name' => Yii::t('app', 'Category'),
                                  'data' => $value,
                                  'colors' => $color,
                              ],                          
                          ],
                      ]
                  ]);
                      ?>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
<!--                   <div class="panel panel-default">
                    <div class="panel-heading"><strong>Despesas por Categoria</strong></div>
                    <div class="panel-body">

                    </div>
                  </div> -->
                </div>
            </div>
            
            </div>
        
 </div>