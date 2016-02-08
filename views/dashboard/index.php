<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('app', 'Dashboards');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dashboard-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Dashboard'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'value',
            'description',
            'date',
            'is_pending',
            // 'attachment',
            // 'inc_datetime',
            // 'edit_datetime',
            // 'user_id',
            // 'category_id',
            // 'type_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
