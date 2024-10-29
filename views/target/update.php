<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Update Goal', [
  'modelClass' => 'Target',
]) . ' #' . $model->id;
?>

<div class="target-update">

  <h2><?= Html::encode($this->title) ?></h2>

  <?= $this->render('_form', [
    'model' => $model,
  ]) ?>

</div>