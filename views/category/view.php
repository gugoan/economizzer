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
            'id_category',
            'desc_category',
            'hexcolor_category',
        ],
    ]) ?>

</div>
