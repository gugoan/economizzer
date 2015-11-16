<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Update Entry', [
    'modelClass' => 'Cashbook',
]) . ' #' . $model->id;
?>
<div class="cashbook-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
