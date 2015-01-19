<?php
use miloschuman\highcharts\Highcharts;
use yii\bootstrap\Nav;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
$this->title = 'Economizzer';
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
			        ],
			        [
			            'label' => 'Por Categoria',
			            'url' => ['site/index'],
			            'options' => ['class' => 'disabled'],
			        ],
			        [
			            'label' => 'Desempenho',
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
            <div class="panel">
              <div class="panel-heading"><i class="fa fa-line-chart"></i> Acompanhamento do Mês</div>
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
                //array_filter($type1, 'is_numeric');
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
                      'title' => ['text' => 'Acompanhamento do Mês'],
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
        </div>
 </div>

