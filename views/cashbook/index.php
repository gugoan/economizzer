<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CashbookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cashbooks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cashbook-index">

    <h1>Lançamentos</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
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
        'filterModel' => $searchModel,
        'tableOptions'=>['class'=>'table table-striped'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
             'header' => 'Dia',
             'attribute' => 'date',
             'enableSorting' => true,
             'format' => ['date', 'php:d/m/Y'],
            ],
            [
             'header' => 'Categoria',
             'attribute' => 'category_id',
             'enableSorting' => true,
             //'value' => 'category_id.desc_category'
            ],
            ['class' => 'yii\grid\ActionColumn'],
            [
             'header' => 'Valor',
             'attribute' => 'value',
             'enableSorting' => true,
             //'value' => 'category_id.desc_category'
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
