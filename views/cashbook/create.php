<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Cashbook */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Cashbook',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cashbooks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cashbook-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
