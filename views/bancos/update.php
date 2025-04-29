<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Atualizar Banco', [
  'modelClass' => 'Banco',
]) . ' #' . $model->nome;
?>

<div class="bancos-update">

  <?= $this->render('_form', [
    'model' => $model,
  ]) ?>

</div>