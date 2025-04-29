<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProdutosClientes */

$this->title = 'Atualizar Produto: ' . Html::encode($model->produto);
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="produto-update">
  <?php $form = ActiveForm::begin([
    'id' => 'produtoUpdateForm',
    'action' => ['cliente/update-product'], // Define a rota da ação de update
    'method' => 'post',
  ]); ?>
  <!-- Campo oculto para o ID do produto -->
  <?= Html::hiddenInput('id', null, ['id' => 'product-id']) ?>

  <?= $form->field($model, 'produto')->textInput(['id' => 'product-name', 'maxlength' => true]) ?>
  <?= $form->field($model, 'quantidade')->textInput(['id' => 'quantity', 'type' => 'number']) ?>
  <?= $form->field($model, 'valor_cliente')->textInput(['id' => 'client-value', 'type' => 'number', 'step' => '0.01']) ?>
  <?= $form->field($model, 'valor_pagamento')->textInput(['id' => 'payment-value', 'type' => 'number', 'step' => '0.01']) ?>
  <?= $form->field($model, 'data')->textInput(['id' => 'date', 'type' => 'date']) ?>
  <?= $form->field($model, 'data_entrega')->textInput(['id' => 'delivery-date', 'type' => 'date']) ?>

  <?= Html::hiddenInput('productId', null, ['id' => 'product-id']) ?>

  <div class="form-group">
    <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary']) ?>
  </div>

  <?php ActiveForm::end(); ?>
</div>