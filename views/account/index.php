<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('app', 'Accounts');
?>
<div class="account-index">

    <h2>
        <span><?= Html::encode($this->title) ?></span>
        <?= Html::a('<i class="fa fa-plus"></i> '.Yii::t('app', 'Create').'', ['/account/create'], ['class'=>'btn btn-primary grid-button pull-right']) ?>
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
        //'filterModel' => $searchModel,
        'tableOptions' => ['class'=>'table table-striped table-hover'],
        'summary'     =>  '',
        'columns' => [
            'description',
            'currency.name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>

</div>
