<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
<h2>
  <span><?= Html::encode($this->title) ?></span>
    <?= Html::a('<i class="fa fa-plus"></i> '.Yii::t('app', 'Category').'', ['/category/create'], ['class'=>'btn btn-primary grid-button btn-sm pull-right']) ?>
</h2>
<hr/>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'tableOptions' => ['class'=>'table table-striped table-condensed table-hover'],
        'summary'     =>  '',
        'columns' => [
            'id_category',
            'desc_category',
            'hexcolor_category',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
