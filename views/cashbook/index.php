<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Cashbook;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CashbookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Lançamentos');
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="row">
        <div class="col-xs-6 col-md-3">
            <div class="panel panel-primary">
              <div class="panel-heading"><i class="fa fa-search"></i> Filtros</div>
              <div class="panel-body">
                <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
              </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-9">

<div class="cashbook-index">
<h2>
  <span>Lançamentos</span>
    <?= Html::a('<i class="fa fa-plus"></i> Lançamento', ['/cashbook/create'], ['class'=>'btn btn-primary grid-button btn-sm pull-right']) ?>
</h2>
<hr/>
 
    <?php
        // http://stackoverflow.com/questions/27066544/yii2-adding-filter-to-gridview-widget  
        //$searchModel = New CashbookSearch(); 
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel'  => $searchModel,
        'tableOptions' => ['class'=>'table table-striped table-hover'],
        'emptyText'    => '</br><p class="text-danger">Nenhum lançamento encontrado!</p>',
        'summary'      =>  '',
        'showFooter'   => true,
        'showOnEmpty'  => false,
        'footerRowOptions'=>['style'=>'font-weight:bold;'],
        'columns'      => [
            //['class' => 'yii\grid\SerialColumn'],
            [
             'label' => 'Dia',
             'attribute' => 'date',
             'enableSorting' => true,
             'format' => ['date', 'php:d/m/Y'],
             'contentOptions'=>['style'=>'width: 10%;text-align:left'],
            ],
            [
             'label' => 'Categoria',
             'attribute' => 'category_id',
             'format' => 'raw',
             'enableSorting' => true,
             //'value' => 'category.desc_category',
             'value' => function ($model) {                      
                    return $model->category->desc_category.' <em class="text-info">('.$model->description.')</em>';
                    },
             'contentOptions'=>['style'=>'width: 45%;text-align:left'],
            ],
            /*
            [
             'header' => '',
             'attribute' => 'description',
             'format' => 'text',
             'contentOptions'=>['style'=>'width: 45%;text-align:left'],
            ],
            */
            [
             'class' => 'yii\grid\ActionColumn',
             //'header' => 'teste',
             'template' => '{attachment} {view} {update} {delete}',
             'buttons' => [
                'attachment' => function ($url, $model) {
                    return Html::a('<span class="fa fa-paperclip"></span>', $url, [
                                'title' => Yii::t('app', 'Visualizar anexo'),
                                //'class'=>'btn btn-primary btn-xs',                                  
                    ]);
                },
                ],
             'contentOptions'=>['style'=>'width: 15%;text-align:center'],
             'footer' => 'Total',
             'footerOptions' => ['style'=>'text-align:center'],             
            ],
            [
             //'header' => 'Valor',
             'label' => 'Valor',
             'attribute' => 'value',
             'format' => 'raw',
             'value' => function ($model) {                      
                    return '<strong style="color:'.$model->type->hexcolor_type.'"> R$ '.$model->value.'</strong>';
                    },
             'enableSorting' => true,
             'contentOptions'=>['style'=>'width: 10%;text-align:left'],
             'footer' => Cashbook::pageTotal($dataProvider->models,'value'),
             //'footerOptions' => '',
            ],
            //'id',
            //'category_id',
            //'type_id',
            //'value',
            //'description',
            // 'date',
            // 'is_pending',
            // 'attachment',
            // 'inc_datetime',
            // 'edit_datetime',
        ],
    ]); ?>

</div>

        </div>
    </div>