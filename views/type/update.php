<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Type */

$this->title = Yii::t('app', 'Alterar Tipo de Lançamento: ', [
    'modelClass' => 'Type',
]) . ' ' . $model->desc_type;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tipos de Lançamento'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_type, 'url' => ['view', 'id' => $model->id_type]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="type-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
