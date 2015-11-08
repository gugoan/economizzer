<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Account',
]) . ' ' . $model->id;

?>
<div class="account-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
