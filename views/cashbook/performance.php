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
$this->title = Yii::t('app', 'Annual Performance');
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
                <?php echo Cashbook::monthlysummary(1);?>
                </br>
                <?php echo Cashbook::monthlysummary(2);?>
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
                /* complex example 
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
            ]); */
                ?>
            </div>
            
            </div>
        </div>