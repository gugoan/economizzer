<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CashbookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Lançamentos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cashbook-index">

    <h1>Lançamentos</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', '<i class="fa fa-plus"></i> Novo', [
    'modelClass' => 'Cashbook',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php
    // http://stackoverflow.com/questions/27066544/yii2-adding-filter-to-gridview-widget  
    //$searchModel = New CashbookSearch(); 
    //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel'  => $searchModel,
        'tableOptions' => ['class'=>'table table-striped'],
        'emptyText'    => 'Nenhum lançamento encontrado!',
        'summary'     =>  '',
        'columns'      => [
            //['class' => 'yii\grid\SerialColumn'],
            [
             'header' => 'Dia',
             'attribute' => 'date',
             'enableSorting' => true,
             'format' => ['date', 'php:d/m/Y'],
             'contentOptions'=>['style'=>'width: 10%;text-align:left'],
            ],
            [
             'header' => 'Categoria',
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
             'contentOptions'=>['style'=>'width: 15%;text-align:center'],
            ],
            [
             'header' => 'Valor',
             'attribute' => 'value',
             'value' => function ($model) {                      
                    return 'R$ '.$model->value;
                    },
             'enableSorting' => true,
             'contentOptions'=>['style'=>'width: 10%;text-align:left'],
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
