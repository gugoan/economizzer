<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'New Entry', [
    'modelClass' => 'Cashbook',
]);
?>
<div class="cashbook-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>