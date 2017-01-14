<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->desc_category;
?>
<div class="category-view">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr/>
    <h2 class="pull-right">
    
        <?= Html::a('<i class="fa fa-pencil-square-o"></i> '.Yii::t('app', 'Update'), ['update', 'id' => $model->id_category], [
                'class' => 'btn btn-primary',
                ]
                ) ?> 
        <?= Html::a('<i class="glyphicon glyphicon-trash"></i> '.Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_category], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete?'),
                    'method' => 'post',
                ],
        ]) ?>
    </h2>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'desc_category',
            [
            'attribute' => 'hexcolor_category',
            'format' => 'raw',
            'value' => '<strong style="color:'.$model->hexcolor_category.'"><i class="fa fa-tag"></i></strong>',
            ],
            [
            'attribute' => 'parent_id',
            'format' => 'raw',
            'value' => $model->parent ? $model->parent->desc_category : null,
            ],
            [
            'attribute' => 'is_active',
            'format' => 'raw',
            'value' => $model->is_active == 1 ? Yii::t('app', 'Yes') : Yii::t('app', 'No'),
            ],
        ],
    ]) ?>

</div>
