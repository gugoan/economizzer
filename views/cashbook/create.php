<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'New Entry', [
    'modelClass' => 'Cashbook',
]);
?>
<div class="cashbook-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
