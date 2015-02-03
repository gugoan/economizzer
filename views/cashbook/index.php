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
        <div class="col-sm-3">
            <div class="panel panel-primary">
              <div class="panel-heading"><i class="fa fa-search"></i> Filtros</div>
              <div class="panel-body">
                <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
              </div>
            </div>
        </div>
        <div class="col-sm-9">

<div class="cashbook-index">
<h2>
  <span>Lançamentos</span>
    <?= Html::a('<i class="fa fa-plus"></i> Lançamento', ['/cashbook/create'], ['class'=>'btn btn-primary grid-button btn-sm pull-right']) ?>
</h2>
<hr/>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class'=>'table table-striped table-hover'],
        'emptyText'    => '</br><p class="text-danger">Nenhum lançamento encontrado!</p>',
        'summary'      =>  '',
        'showFooter'   => true,
        'showOnEmpty'  => false,
        'footerRowOptions'=>['style'=>'font-weight:bold;'],
        'rowOptions' => function($model){
            if($model->is_pending == 1)
                {
                    return ['class' => 'warning'];
                }
        },
        'columns'    => [
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
             'value' => function ($model) {                      
                    return $model->category->desc_category.' <em class="text-info">('.$model->description.')</em>';
                    },
             'contentOptions'=>['style'=>'width: 45%;text-align:left'],
            ],
            [
             'class' => 'yii\grid\ActionColumn',
             'template' => '{attachment} {view} {update} {delete}',
             'buttons' => [
                'attachment' => function ($url, $model) {
                    return $model->attachment <> '' ? Html::a('<span class="fa fa-paperclip fa-fw fa-border"></span>', $url, [
                                'title' => Yii::t('app', 'Possui Anexo'),
                                //'class'=>'btn btn-primary btn-xs',                                  
                    ]) : '';
                },
                // return $model->status == 1 ? Html::a('<span class="fa fa-search"></span>View', $url, [ 'title' => Yii::t('app', 'View'), 'class'=>'btn btn-primary btn-xs', ]) : '';
                'view' => function ($url, $model) {
                    return Html::a('<span class="fa fa-eye fa-fw fa-border"></span>', $url, [
                                'title' => Yii::t('app', 'Exibir Lançamento'),
                                //'class'=>'btn btn-primary btn-xs',                                  
                    ]);
                },   
                'update' => function ($url, $model) {
                    return Html::a('<span class="fa fa-pencil-square-o fa-fw fa-border"></span>', $url, [
                                'title' => Yii::t('app', 'Alterar Lançamento'),
                                //'class'=>'btn btn-primary btn-xs',                                  
                    ]);
                }, 
                'delete' => function ($url, $model) {
                    return Html::a('<span class="fa fa-trash-o fa-fw fa-border"></span>', $url, [
                                'title' => Yii::t('app', 'Excluir Lançamento'),
                                //'class'=>'btn btn-primary btn-xs',         
                                'data-confirm' => Yii::t('yii', 'Deseja realmente excluir este lançamento?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',                         
                    ]);
                },                                                  
             ],
             'contentOptions'=>['style'=>'width: 15%;text-align:right'],
             'footer' => 'Total',
             'footerOptions' => ['style'=>'text-align:center'],             
            ],
            [
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