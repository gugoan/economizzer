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

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::a(Yii::t('app', 'Alterar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a(Yii::t('app', 'Excluir'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => Yii::t('app', 'Tem certeza que deseja excluir?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
            'attribute' => 'value',
            'value' => "R$ ".$model->value,
            ],
            [
            'label' => 'Tipo',
            'value' => $model->type->desc_type,
            ],
            [
            'label' => 'Categoria',
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
             'value' => $model->is_pending == 1 ? '<span class="label label-warning">Sim</span' : 'Não'
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
