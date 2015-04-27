<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Cashbook;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CashbookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Entries');
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="row">
        <div class="col-sm-3">
            <div class="panel panel-primary">
              <div class="panel-heading"><i class="fa fa-search"></i> <?php echo Yii::t('app', 'Filters');?></div>
              <div class="panel-body">
                <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
              </div>
            </div>
        </div>
        <div class="col-sm-9">

<div class="cashbook-index">
<h2>
  <span><?= Html::encode($this->title) ?></span>
    <?= Html::a('<i class="fa fa-plus"></i> '.Yii::t('app', 'Entry').'', ['/cashbook/create'], ['class'=>'btn btn-primary grid-button btn-sm pull-right']) ?>
</h2>
<hr/>
    <?php if ($flash = Yii::$app->session->getFlash("Entry-success")): ?>

        <div class="alert text-success">
            <p><em><?= $flash ?></em></p>
        </div>

    <?php endif; ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class'=>'table table-striped table-hover'],
        'emptyText'    => '</br><p class="text-danger">'.Yii::t('app', 'No entries found!').'</p>',
        'summary'      =>  '',
        'showFooter'   => true,
        'showOnEmpty'  => false,
        'footerRowOptions'=>['style'=>'font-weight:bold;'],
        // 'rowOptions' => function($model){
        //     if($model->is_pending == 1)
        //         {
        //             return ['class' => 'text-warning'];
        //         }
        // },
        'columns'    => [
            [
             'attribute' => 'date',
             'enableSorting' => true,
             //'format' => ['date', 'php:d/m/Y'],
             //'value' => Yii::$app->formatter->asDate($model->date, 'short'),
                          'value' => function ($model) {                      
                    return $model->date <> '' ? Yii::$app->formatter->asDate($model->date, 'short') : Yii::$app->formatter->asDate($model->date, 'short');
                    },
             'contentOptions'=>['style'=>'width: 10%;text-align:left'],
            ],
            [
             'attribute' => 'category_id',
             'format' => 'raw',
             'enableSorting' => true,
             'value' => function ($model) {                      
                    return $model->description <> '' ? '<span style="color:'.$model->category->hexcolor_category.'">'.$model->category->desc_category.'</span>'.' <em class="text-muted">('.$model->description.')</em>' : '<span style="color:'.$model->category->hexcolor_category.'">'.$model->category->desc_category.'</span>';
                    },
             'contentOptions'=>['style'=>'width: 35%;text-align:left'],
            ],
            [
             'class' => 'yii\grid\ActionColumn',
             'template' => '{pending} {attachment} {view} {update} {delete}',
             'buttons' => [
                 'pending' => function ($url, $model) {
                        return $model->is_pending <> 0 ? Html::a('<span class="glyphicon glyphicon-alert text-danger" ></span>', $url, [
                                    'title' => Yii::t('app', 'Pending'),
                                    //'class'=>'btn btn-primary btn-xs',                                  
                        ]) : '';
                },
                'attachment' => function ($url, $model) {
                    return $model->attachment <> '' ? Html::a('<span class="glyphicon glyphicon-paperclip"></span>', $url, [
                                'title' => Yii::t('app', 'Receipt'),
                                //'class'=>'btn btn-primary btn-xs',                                  
                    ]) : '';
                },
                // 'view' => function ($url, $model) {
                //     return Html::a('<span class="fa fa-eye fa-fw fa-border"></span>', $url, [
                //                 'title' => Yii::t('app', 'Exibir Lançamento'),
                //     ]);
                // },   
                // 'update' => function ($url, $model) {
                //     return Html::a('<span class="fa fa-pencil-square-o fa-fw fa-border"></span>', $url, [
                //                 'title' => Yii::t('app', 'Alterar Lançamento'),                                
                //     ]);
                // }, 
                // 'delete' => function ($url, $model) {
                //     return Html::a('<span class="fa fa-trash-o fa-fw fa-border"></span>', $url, [
                //                 'title' => Yii::t('app', 'Excluir Lançamento'),       
                //                 'data-confirm' => Yii::t('yii', 'Deseja realmente excluir este lançamento?'),
                //                 'data-method' => 'post',
                //                 'data-pjax' => '0',                         
                //     ]);
                // },                                                  
             ],
             'contentOptions'=>['style'=>'width: 20%;text-align:right'],
             'footer' => 'Total',
             'footerOptions' => ['style'=>'text-align:right'],             
            ],
            [
             'label' => '',
             'attribute' => 'value',
             'format' => 'raw',
             'value' => function ($model) {                      
                    return '<strong style="color:'.$model->type->hexcolor_type.'">'.Yii::t('app', '$').' '.$model->value.'</strong>';
                    },
             'enableSorting' => true,
             'contentOptions'=>['style'=>'width: 15%;text-align:right'],
             //'options' => ['width' => '10%',],
             'footer' => Cashbook::pageTotal($dataProvider->models,'value'),
             'footerOptions' => ['style'=>'text-align:right'],
            ],
        ],
    ]); ?>

</div>

        </div>
    </div>