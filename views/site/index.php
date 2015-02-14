<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\bootstrap\Nav;
use yii\data\SqlDataProvider;
use yii\grid\GridView;
/* @var $this yii\web\View */
$this->title = 'Economizzer';
$this->title = Yii::t('app', 'Overview');
$this->params['breadcrumbs'][] = $this->title;


$thisyear  = date('Y');
$thismonth = date('m');
$lastmonth = date('m', strtotime('-1 months', strtotime(date('Y-m-d'))));
$user      = Yii::$app->user->identity->id;
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
          <span><?php echo Yii::t('app', 'Summary of the Month');?> <small><?php echo $thismonth."/".$thisyear ?></small></span>
        </h2>
        <hr/>
            <div class="row">
                  <div class="col-md-6">
                  <div class="panel panel-primary">
                <div class="panel-heading"><strong><?php echo Yii::t('app', 'Revenue x Expenses');?></strong></div>
                  <div class="panel-body">       
                  <?php
          // Via Query Builder
          /*
          $query = (new \yii\db\Query())->from('tb_cashbook');
          $sum = $query->sum('value');
          echo $sum."</br>";
          */
          // Via Data Access Objects
          $command = Yii::$app->db->createCommand("SELECT sum(value) FROM tb_cashbook WHERE user_id = $user AND type_id = 1 AND MONTH(date) = $thismonth AND YEAR(date) = $thisyear");
          $vtype1 = $command->queryScalar();

          $command = Yii::$app->db->createCommand("SELECT sum(value) FROM tb_cashbook WHERE user_id = $user AND type_id = 2 AND MONTH(date) = $thismonth AND YEAR(date) = $thisyear");
          $vtype2 = $command->queryScalar();

          // get las month values;
          $lastmonth_command = Yii::$app->db->createCommand("SELECT sum(value) FROM tb_cashbook WHERE user_id = $user AND type_id = 1 AND MONTH(date) = $lastmonth AND YEAR(date) = $thisyear");
          $lastmonth_type1 = $lastmonth_command->queryScalar();

          $lastmonth_command = Yii::$app->db->createCommand("SELECT sum(value) FROM tb_cashbook WHERE user_id = $user AND type_id = 2 AND MONTH(date) = $lastmonth AND YEAR(date) = $thisyear");
          $lastmonth_type2 = $lastmonth_command->queryScalar();

          // get overbalance
          if(round((int)$vtype1) >= abs(round((int)$vtype2)))
          {
            $overbalance = "<span class=\"label label-success\">".Yii::t('app', 'Positive')." <i class=\"fa fa-smile-o\"></i></span>";
          }else{
            $overbalance = "<span class=\"label label-danger\">".Yii::t('app', 'Negative')." <i class=\"fa fa-frown-o\"></i></span>";
          }
          // sign_types
          if ((int)$vtype1 < (int)$lastmonth_type1)
          {
            $sign_type1 = "<i class=\"fa fa-long-arrow-up\" style=\"color:#18bc9c;\">";
          }else{
            $sign_type1 = "<i class=\"fa fa-arrow-down\" style=\"color:#e74c3c;\">";
          }
          if (abs((int)$vtype2) < abs((int)$lastmonth_type2))
          {
            $sign_type2 = "<i class=\"fa fa-long-arrow-up\" style=\"color:#e74c3c;\">";
          }else{
            $sign_type2 = "<i class=\"fa fa-arrow-down\" style=\"color:#18bc9c;\">";
          }

            echo Highcharts::widget([
                'options' => [
                    'plotOptions ' => 'pie',
                    'credits' => ['enabled' => false],
                    'chart'=> [
                    'height'=> 300,
                    ],
                    'title' => ['text' => ''],
                    'colors'=> ['#18bc9c','#e74c3c'],
                    'tooltip'=> ['pointFormat'=> Yii::t('app', 'Percentage').': <b>{point.percentage:.1f}%</b>'],
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
                            [Yii::t('app', 'Revenue'),   round((int)$vtype1)],
                            [Yii::t('app', 'Expenses'),   abs(round((int)$vtype2))],
                        ]
                    ]]
                ]
                ]);
                ?></div></div></div>
                  <div class="col-md-6">
                      <div class="panel panel-primary">
                    <div class="panel-heading"><strong><?php echo Yii::t('app', 'Performance');?></strong></div>
                    <div class="panel-body">
                    <h3><?php echo Yii::t('app', 'Monthly balance').": ".$overbalance;?></h3>
                    <br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th><?php echo Yii::t('app', 'Current Month');?></th>
                                <th><?php echo Yii::t('app', 'Previous Month');?></th>
                                <th><i class="fa fa-line-chart"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo Yii::t('app', 'Revenue');?></td>
                                <td><?php echo "R$ ".(int)$vtype1;?></td>
                                <td><?php echo "R$ ".(int)$lastmonth_type1;?></td>
                                <td><?php echo $sign_type1;?></td>
                            </tr>
                            <tr>
                                <td><?php echo Yii::t('app', 'Expenses');?></td>
                                <td><?php echo "R$ ".abs((int)$vtype2);?></td>
                                <td><?php echo "R$ ".abs((int)$lastmonth_type2);?></td>
                                <td><?php echo $sign_type2;?></td>
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