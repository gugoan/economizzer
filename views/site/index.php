<?php
use miloschuman\highcharts\Highcharts;
/* @var $this yii\web\View */
$this->title = 'Economizzer';
?>
<div class="row">
        <div class="col-xs-12 col-sm-6 col-md-9">
            <div class="panel panel-primary">
              <div class="panel-heading"><i class="fa fa-chart"></i> Acompanhamento do Mês</div>
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
				         ['name' => 'Receita', 'data' => [1, 0, 4]],
				         ['name' => 'Despesa', 'data' => [5, 7, 3]]
				      ]
				   ]
				]);
				?>
            </div>
        </div>
        <div class="col-xs-6 col-md-3">
        	<div class="panel panel-primary">
              <div class="panel-heading"><i class="fa fa-search"></i> Filtros</div>
              
            </div>
        </div>
 </div>

