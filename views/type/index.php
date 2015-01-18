<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tipos de Lançamento');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'tableOptions' => ['class'=>'table table-striped'],
        'summary'     =>  '',
        'columns'      => [
            [
             'header' => 'Descrição',
             'attribute' => 'desc_type',
             'contentOptions'=>['style'=>'width: 30%;text-align:left'],
            ],
            [
             'header' => 'Cor',
             'attribute' => 'hexcolor_type',
             'format' => 'raw',
             'value' => function ($model) {                      
                    return '<strong style="color:'.$model->hexcolor_type.'"><i class="fa fa-circle"></i> '.$model->hexcolor_type.'</strong>';
                    },
             'contentOptions'=>['style'=>'width: 30%;text-align:left'],
            ],
            //'icon_type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
