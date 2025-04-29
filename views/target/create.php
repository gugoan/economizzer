<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'New Goal', [
  'modelClass' => 'Target',
]);
?>
<div class="target-create">

  <h2><?= Html::encode($this->title) ?></h2>

  <?= $this->render('_form', [
    'model' => $model,
  ]) ?>

</div>