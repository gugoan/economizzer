<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cashbook */

$this->title = Yii::t('app', 'Entry') . " #".$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entry'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cashbook-view">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr/>
    <h2 class="pull-right">
        
        <?= Html::a('<i class="fa fa-pencil-square-o"></i> '.Yii::t('app', 'Update'), ['update', 'id' => $model->id], [
                'class' => 'btn btn-primary ',
                ]
                ) ?> 
        <?= Html::a('<i class="glyphicon glyphicon-trash"></i> '.Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete?'),
                    'method' => 'post',
                ],
        ]) ?>
        
    </h2>
    

    <?php if ($flash = Yii::$app->session->getFlash("Entry-success")): ?>

        <div class="alert text-success">
            <p><em><?= $flash ?></em></p>
        </div>

    <?php endif; ?>

    <h1 class="text-hide">Custom heading</h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
            'attribute' => 'value',
            'format' => 'raw',
            //'value' => Yii::t('app', '$')." ".$model->value,
            'value' => $model->type_id == 1 ? '<span class="label label-success">'.Yii::t('app', '$')." ".$model->value.'</span>' : '<span class="label label-danger">'.Yii::t('app', '$')." ".$model->value.'</span>'
            ],
            [
            'attribute' => 'category_id',
            'value' => $model->category->desc_category,
            ],
            [
            'attribute' => 'date',
            'format' => ['date', 'd/M/Y'],
            ],
            'description',
            [
             'attribute' => 'is_pending',
             'format' => 'raw',
             'value' => $model->is_pending == 1 ? '<span class="label label-warning">'.Yii::t('app', 'Yes').'</span' : Yii::t('app', 'No'),
            ],
            [
           'attribute'=>'attachment',
           'format' => 'raw',
           'value' => $model->attachment == null ? Yii::t('app', 'No attachment') : '<span class="glyphicon glyphicon-paperclip"></span> '.Html::a(Yii::t('app', 'Attach'),"/economizzer/web/attachment/".$model->user_id."/".$model->attachment, ['target' => '_blank']),
            ],            
            [
            'attribute' => 'inc_datetime',
            'value' => Yii::$app->formatter->asDate($model->inc_datetime, 'long'),
            ],            
            [
            'attribute' => 'edit_datetime',
            'value' => Yii::$app->formatter->asDate($model->inc_datetime, 'long'),
            //'format' => ['date', 'd/M/Y H:m:s'],
            ],             
        ],
    ]) ?>

</div>
