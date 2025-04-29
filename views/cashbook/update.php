<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Update Entry', [
    'modelClass' => 'Cashbook',
]) . ' #' . $model->id;
?>

<div class="cashbook-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>