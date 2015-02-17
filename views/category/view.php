<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = $model->desc_category;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

    <h1>
        <span><?= Html::encode($this->title) ?></span>
        <div class="pull-right">
            <?= Html::a(Yii::t('app', '<i class="glyphicon glyphicon-pencil"></i> Update'), ['update', 'id' => $model->id_category], [
                    'class' => 'btn btn-primary btn-sm',
                    //'options' => ['style'=> 'margin-right: 2;margin-left: 2'],
                    //'contentOptions'=>['style'=>'margin-right: 2px;']
                    ]
                    ) ?> 
            <?= Html::a(Yii::t('app', '<i class="glyphicon glyphicon-trash"></i> Delete'), ['delete', 'id' => $model->id_category], [
                    'class' => 'btn btn-danger btn-sm',
                    'data' => [
                        'confirm' => Yii::t('app', 'Tem certeza que deseja excluir?'),
                        'method' => 'post',
                    ],
            ]) ?>
        </div>
    </h1>
    <hr/>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_category',
            'desc_category',
            'hexcolor_category',
        ],
    ]) ?>

</div>
