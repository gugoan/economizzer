<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Cashbook;

$this->title = Yii::t('app', 'Entries');
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="row">
        <div class="col-sm-3">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title"><i class="fa fa-search"></i> <?php echo Yii::t('app', 'Filters');?>
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">
                      <span class="glyphicon glyphicon-resize-small pull-right" aria-hidden="true"></span>
                    </a>
                  </h4>
                </div>
                <div id="collapseFilter" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="col-sm-9">

<div class="cashbook-index">
<h2>
  <span><?= Html::encode($this->title) ?></span>
    <?= Html::a('<i class="fa fa-plus"></i> '.Yii::t('app', 'Create').'', ['/cashbook/create'], ['class'=>'btn btn-primary grid-button pull-right']) ?>
</h2>
<hr/>
    <!-- Alerts -->
    <?php foreach (Yii::$app->session->getAllFlashes() as $key=>$message):?>
        <?php $alertClass = substr($key,strpos($key,'-')+1); ?>
        <div class="alert alert-dismissible alert-<?=$alertClass?>" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p><?=$message?></p>
        </div>
    <?php endforeach ?>
    
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
             'footer' => 'Total',
             'footerOptions' => ['style'=>'text-align:letf'],                  
            ],
            [
                'attribute' => 'account.description',
                'header' => Yii::t('app','Account'),
                //'format' => 'raw',
//                'enableSorting' => true,
//                'value' => function ($model) {
//                    return $model->description <> '' ? '<span style="color:'.$model->category->hexcolor_category.'">'.$model->category->desc_category.'</span>'.' <em class="text-muted">('.$model->description.')</em>' : '<span style="color:'.$model->category->hexcolor_category.'">'.$model->category->desc_category.'</span>';
//                },
//                'contentOptions'=>['style'=>'width: 35%;text-align:left'],
//                'footer' => 'Total',
//                'footerOptions' => ['style'=>'text-align:letf'],
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
             'contentOptions'=>['style'=>'width: 25%;text-align:right'],
            ],
            [
             'label' => '',
             'attribute' => 'value',
             'format' => 'raw',
             'value' => function ($model) {                      
                    return '<strong style="color:'.$model->type->hexcolor_type.'">'.(isset($model->account)?$model->account->currency->iso_code:Yii::t('app','$')).' '.$model->value.'</strong>';
                    },
             'enableSorting' => true,
             'contentOptions'=>['style'=>'width: 25%;text-align:right'],
             //'options' => ['width' => '10%',],
             'footer' => Cashbook::pageTotal($dataProvider->models,'value'),
             'footerOptions' => ['style'=>'text-align:right'],
            ],
        ],
    ]); ?>

</div>

        </div>
    </div>