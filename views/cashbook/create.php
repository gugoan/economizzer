<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Cashbook */

$this->title = Yii::t('app', 'Novo Lançamento', [
    'modelClass' => 'Cashbook',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lançamentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cashbook-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
