<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cashbook */

$this->title = Yii::t('app', 'Lançamento') . " #".$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lançamento'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cashbook-view">

    <h2>
        <span><?= Html::encode($this->title) ?></span>
        <div class="pull-right">
        <?= Html::a(Yii::t('app', '<i class="glyphicon glyphicon-pencil"></i> Alterar'), ['update', 'id' => $model->id], [
                'class' => 'btn btn-primary btn-sm',
                //'options' => ['style'=> 'margin-right: 2;margin-left: 2'],
                //'contentOptions'=>['style'=>'margin-right: 2px;']
                ]
                ) ?> 
        <?= Html::a(Yii::t('app', '<i class="glyphicon glyphicon-trash"></i> Excluir'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-sm',
                'data' => [
                    'confirm' => Yii::t('app', 'Tem certeza que deseja excluir?'),
                    'method' => 'post',
                ],
        ]) ?>
        </div>
    </h2>
    <hr/>

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
            'format' => ['date', 'd/M/Y H:m:s'],
            ],            
            [
            'attribute' => 'edit_datetime',
            'format' => ['date', 'd/M/Y H:m:s'],
            ],             
        ],
    ]) ?>

</div>
