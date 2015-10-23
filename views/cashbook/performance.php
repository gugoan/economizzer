<?php

use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\data\SqlDataProvider;
use app\models\Cashbook;

$this->title = 'Economizzer';
$this->title = Yii::t('app', 'Annual Performance');

?>
<div class="row">
        <div class="col-sm-3">
            <?php  echo $this->render('_menu'); ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-9">
        <h2>
          <span><?php echo $this->title; ?></span>
        </h2>
        <hr/>
            <div class="row">
            <div class="container-fluid">
                <div class="panel panel-default">
                <div class="panel-heading"><strong><?php echo Yii::t('app', 'Monthly Comparative Revenue x Expense');?></strong></div>
                <div class="panel-body">
                <?php
                echo Highcharts::widget([
                    'options' => [
                        'credits' => ['enabled' => false],
                        'title' => [
                            'text' => '',
                        ],
                        'colors'=> ['#18bc9c','#e74c3c'],
                        'xAxis' => [
                            'categories' => $m,
                        ],
                          'yAxis' => [
                             'title' => ['text' => ''],
                        ],                        
                        'series' => [
                            [
                                'type' => 'column',
                                'name' => Yii::t('app', 'Revenue'),
                                'data' => $v1,
                            ],
                            [
                                'type' => 'column',
                                'name' => Yii::t('app', 'Expense'),
                                'data' => $v2,
                            ],
                        ],
                    ]
                ]);
                ?></div></div>
            </div>
            </div>
            </div>
        </div>