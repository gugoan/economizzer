<?php
use miloschuman\highcharts\Highcharts;
use yii\bootstrap\Nav;
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
				// https://github.com/miloschuman/yii2-highcharts
				echo Highcharts::widget([
				   'options' => [
				   'credits' => ['enabled' => false],
				      'title' => ['text' => 'Acompanhamento do Mês'],
				      'xAxis' => [
				         'categories' => ['Apples', 'Bananas', 'Oranges']
				      ],
				      'yAxis' => [
				         'title' => ['text' => 'Valor']
				      ],
				      'series' => [
				         [
				         'name' => 'Receita',
				         'color' => '#18bc9c',
				         'data' => [1, 0, 4],
				         ],
				         [
				         'name' => 'Despesa',
				         'color' => '#e74c3c',
				         'dashStyle' => 'ShortDash',
				         'data' => [5, 7, 3],
				         ]
				      ]
				   ]
				]);
				?>
            </div>
        </div>
 </div>

