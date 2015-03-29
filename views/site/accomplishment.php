<?php

use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\data\SqlDataProvider;
use app\models\Cashbook;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CashbookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Economizzer';
$this->title = Yii::t('app', 'Accomplishment');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
        <div class="col-xs-6 col-md-3">
            <?php  echo $this->render('_menu'); ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-9">
        <h2>
          <span><?php echo $this->title; ?></span>
        </h2>
        <hr/>
            <div class="row">
                <?php //echo Cashbook::monthlysummary(1);?>
				</br>
				<?php //echo Cashbook::monthlysummary(2);?>
				</br>
				<?php
				echo Highcharts::widget([
			   'options' => [
			   		  'credits' => ['enabled' => false],
				      'title' => ['text' => ''],
				      'colors'=> ['#18bc9c','#e74c3c'],
				      'xAxis' => [
				         'categories' => ['Jan', 'Fev', 'Mar', 'Abr']
				      ],
				      'yAxis' => [
				         'title' => ['text' => '']
				      ],
				      'series' => [
				         //['name' => 'Jane', 'data' => [1, 0, 4]],
				         ['name' => 'Cemig', 'data' => [5, 7, 3, 8]]
				      ]
				   ]
				]);
				?>
            </div>
            
            </div>
        </div>