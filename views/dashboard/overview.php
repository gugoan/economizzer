<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
use app\models\Cashbook;

$this->title = 'Economizzer';
$this->title = Yii::t('app', 'Overview');

$thisyear  = date('Y');
$thismonth = date('m');
$lastmonth = date('m', strtotime('-1 months', strtotime(date('Y-m-d'))));
$user      = Yii::$app->user->identity->id;
?>
<div class="row">
        <div class="col-sm-3">
            <?php  echo $this->render('_menu'); ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-9">
        <h2>
          <span><?php echo Yii::t('app', 'Monthly Summary');?></span>
        </h2>
        <hr/>
            <div class="row">
                  <div class="col-md-6">
                  <div class="panel panel-default">
                <div class="panel-heading"><strong><?php echo Yii::t('app', 'Revenue x Expenses');?></strong></div>
                  <div class="panel-body" style="height: 250px;">       
                  <?php
                  echo Highcharts::widget([
                      'options' => [
                          'credits' => ['enabled' => false],
                          'chart'=> [
                          'height'=> 200,
                          ],
                          'title' => ['text' => null],
                          'colors'=> ['#18bc9c','#e74c3c'],
                          'tooltip'=> ['pointFormat'=> Yii::t('app', 'Percentage').': <b>{point.percentage:.1f}%</b>'],
                          'plotOptions'=> [
                              'pie'=> [
                                  'allowPointSelect'=> true,
                                  'cursor'=> 'pointer',
                                  'dataLabels'=> [
                                      'enabled'=> true,
                                  ],
                                  'center'=> ['50%', '55%'],
                              // 'showInLegend'=> [
                              //     'enabled'=> false,
                              //   ]
                              ]
                          ],
                          'series'=> [[
                              'type'=> 'pie',
                              'name'=> 'Valor',
                              'data'=> [
                                  [Yii::t('app', 'Revenue'),   round((int)$vtype1)],
                                  [Yii::t('app', 'Expense'),   abs(round((int)$vtype2))],
                              ]
                          ]]
                      ]
                      ]);
                      ?>
                  </div></div></div>
                  <div class="col-md-6">
                      <div class="panel panel-default">
                    <div class="panel-heading"><strong><?php echo Yii::t('app', 'Performance');?></strong></div>
                    <div class="panel-body" style="height: 250px;">
                    <?php 
                    // get overbalance
                    if(round((int)$vtype1) >= abs(round((int)$vtype2)))
                    {
                      $overbalance = "<div class=\"alert alert-success\">".Yii::t('app', 'Monthly balance').": <b class=\"pull-right\">".Yii::t('app', 'Positive')." <span class=\"glyphicon glyphicon-thumbs-up\" aria-hidden=\"true\"></span></b></div>";
                    }else{
                      $overbalance = "<div class=\"alert alert-danger\">".Yii::t('app', 'Monthly balance').": <b class=\"pull-right\">".Yii::t('app', 'Negative')." <span class=\"glyphicon glyphicon-thumbs-down\" aria-hidden=\"true\"></span></b></div>";
                    }
                    echo $overbalance;
                    ?>

                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th class="text-center"><i class="fa fa-line-chart"></i></th>
                                <th class="text-center"><?php echo Yii::t('app', 'Current Month');?></th>
                                <th class="text-center"><?php echo Yii::t('app', 'Previous Month');?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo Yii::t('app', 'Revenue');?></td>
                                <td><?php echo Yii::t('app', '$')." ".(int)$vtype1;?></td>
                                <td><?php echo Yii::t('app', '$')." ".(int)$lastmonth_type1;?></td>
                            </tr>
                            <tr>
                                <td><?php echo Yii::t('app', 'Expense');?></td>
                                <td><?php echo Yii::t('app', '$')." ".abs((int)$vtype2);?></td>
                                <td><?php echo Yii::t('app', '$')." ".abs((int)$lastmonth_type2);?></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    </div>
                  </div>
            </div>
            
            </div>
        </div>
 </div>