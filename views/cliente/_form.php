<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Clientes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clientes-form container mt-5">
  <h2 class="text-center mb-4">Cadastro de Clientes</h2>

  <p class="text-muted text-center mb-4">
    Preencha as informações abaixo para criar ou atualizar um cliente.
  </p>

  <?php $form = ActiveForm::begin([
    'options' => ['class' => 'needs-validation', 'novalidate' => true],
  ]); ?>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <?= $form->field($model, 'nome')->textInput([
          'maxlength' => true,
          'placeholder' => 'Digite o nome do cliente',
          'class' => 'form-control input-expand'
        ])->label('Nome do Cliente') ?>
        <small class="form-text text-muted">Exemplo: João da Silva</small>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <?= $form->field($model, 'descricao')->textInput([
          'placeholder' => 'Pagamentos (opcional)',
          'class' => 'form-control input-expand'
        ])->label('Descrição') ?>
        <small class="form-text text-muted">Somente numeros Exemplo: 90 ou 90+90</small>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <?= $form->field($model, 'parcelas')->dropDownList(range(0, 12), [
          'class' => 'form-control input-expand',
          'prompt' => 'Selecione o número de parcelas (opcional)'
        ])->label('Parcelas') ?>
        <small class="form-text text-muted">Número de parcelas para o pagamento.</small>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <?= $form->field($model, 'category_id')->dropDownList(app\models\Category::getHierarchy(), [
          'prompt' => 'Forma de Pagamento (opcional)',
          'class' => 'form-control input-expand'
        ])->label('Categoria') ?>
        <small class="form-text text-muted">Selecione a Forma de Pagamento do cliente.</small>
      </div>
    </div>
  </div>

  <div class="form-group text-center">
    <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Atualizar', [
      'class' => $model->isNewRecord ? 'btn btn-success btn-lg' : 'btn btn-primary btn-lg',
      'style' => 'width: auto; padding: 12px 25px; font-size: 1.2rem;' // Aumenta o tamanho do botão
    ]) ?>
  </div>

  <?php ActiveForm::end(); ?>
</div>

<style>
  .clientes-form {
    background-color: #f8f9fa;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    font-size: 1.7rem;
    /* Aumenta o tamanho da fonte geral */
  }

  .clientes-form h2 {
    font-weight: bold;
    color: #343a40;
    font-size: 2.5rem;
    /* Aumenta o tamanho do título */
  }

  .form-group label {
    font-weight: bold;
    color: #343a40;
    font-size: 1.7rem;
    /* Aumenta o tamanho do label */
  }

  .input-expand {
    transition: background-color 0.3s ease, transform 0.3s ease;
  }

  .input-expand:hover {
    background-color: #e2e6ea;
    /* Muda a cor ao passar o mouse */
    transform: scale(1.02);
    /* Expande um pouco */
  }

  .btn-lg {
    transition: background-color 0.3s ease;
    font-size: 1.5rem;
    /* Aumenta a fonte do botão */
  }

  .btn-success:hover {
    background-color: #218838;
  }

  .btn-primary:hover {
    background-color: #0069d9;
  }

  small.form-text {
    font-size: 1.5rem;
    /* Aumenta o tamanho do texto de ajuda */
    color: #6c757d;
  }
</style>