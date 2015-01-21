<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categorias');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', '<i class="fa fa-plus"></i> Categoria', [
    'modelClass' => 'Category',
]), ['create'], ['class' => 'btn btn-primary btn-sm']) ?>
    </p>

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
