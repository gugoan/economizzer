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

    <h2>
        <span><?= Html::encode($this->title) ?></span>
        <div class="pull-right">
        <?= Html::a(Yii::t('app', '<i class="glyphicon glyphicon-pencil"></i> Update'), ['update', 'id' => $model->id], [
                'class' => 'btn btn-primary btn-sm',
                //'options' => ['style'=> 'margin-right: 2;margin-left: 2'],
                //'contentOptions'=>['style'=>'margin-right: 2px;']
                ]
                ) ?> 
        <?= Html::a(Yii::t('app', '<i class="glyphicon glyphicon-trash"></i> Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-sm',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete?'),
                    'method' => 'post',
                ],
        ]) ?>
        </div>
    </h2>
    <hr/>
    <?php if ($flash = Yii::$app->session->getFlash("Entry-success")): ?>

        <div class="alert text-success">
            <p><em><?= $flash ?></em></p>
        </div>

    <?php endif; ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
            'attribute' => 'value',
            'value' => Yii::t('app', '$')." ".$model->value,
            ],
            [
            'attribute' => 'type_id',
            'value' => $model->type->desc_type,
            ],
            [
            //'label' => 'Categoria',
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
            'attachment',
            [
            'attribute' => 'inc_datetime',
            'value' => Yii::$app->formatter->asDate($model->inc_datetime, 'long'),
            //'inc_datetime:datetime',
            // 'format' => ['date', 'd/M/Y H:m:s'],
            ],            
            [
            'attribute' => 'edit_datetime',
            'format' => ['date', 'd/M/Y H:m:s'],
            ],             
        ],
    ]) ?>

</div>
