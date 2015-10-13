<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cashbook */

$this->title = Yii::t('app', 'Update Entry', [
    'modelClass' => 'Cashbook',
]) . ' #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cashbook-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
        'accountItems' => $accountItems
    ]) ?>

</div>
