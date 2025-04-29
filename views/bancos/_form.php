<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bancos */

$this->params['breadcrumbs'][] = ['label' => 'Bancos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bancos-create container">

  <h1><?= Html::encode($this->title) ?></h1>

  <div class="card">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Informações do Banco</h4>
    </div>
    <div class="card-body">
      <?php $form = ActiveForm::begin(); ?>

      <div class="form-row">
        <div class="form-col">
          <?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'placeholder' => 'Nome do Banco']) ?>
        </div>
        <div class="form-col">
          <?= $form->field($model, 'data_registro')->input('date') ?>
        </div>
      </div>

      <div class="form-row">
        <div class="form-col">
          <?= $form->field($model, 'data_inicio_cartao')->input('date') ?>
        </div>
        <div class="form-col">
          <?= $form->field($model, 'data_fechamento_cartao')->input('date') ?>
        </div>
      </div>

      <?= $form->field($model, 'descricao')->textarea(['rows' => 4, 'placeholder' => 'Descrição do Banco']) ?>

      <!-- Exibe erros de validação, se houver -->
      <?php if ($model->hasErrors()): ?>
        <div class="alert alert-danger">
          <?= Html::errorSummary($model); ?>
        </div>
      <?php endif; ?>

      <div class="form-group text-center">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
      </div>

      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>

<style>
  /* Cabeçalho */
  h1 {
    font-size: 3rem;
    font-weight: bold;
    text-align: center;
    color: #02A8A4;
    margin-bottom: 20px;
  }

  /* Card */
  .card {
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border: none;
  }

  .card-header {
    background-color: #05A796;
    color: #FFFFFF;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    text-align: center;
  }

  .card-header h4 {
    margin: 0;
    font-size: 1.8rem;
  }

  .card-body {
    padding: 20px;
  }

  /* Campos de formulário */
  .form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    /* Espaçamento entre as colunas */
    margin-bottom: 20px;
    justify-content: center;
    /* Centraliza as colunas */
  }

  .form-col {
    flex: 1;
    /* Divide igualmente o espaço */
    min-width: 45%;
    /* Define uma largura mínima */
  }

  .form-group label {
    font-size: 1.9rem;
    /* Ajusta a fonte */
    color: #333;
    display: block;
    text-align: center;
    /* Centraliza o label */
  }

  .form-control {
    border: 1px solid #C4F2EF;
    border-radius: 8px;
    padding: 10px;
    font-size: 1.9rem;
    /* Ajusta a fonte */
    transition: border-color 0.3s, box-shadow 0.3s, transform 0.2s;
  }

  .form-control:hover {
    border-color: #02A8A4;
    /* Cor de destaque ao passar o mouse */
    box-shadow: 0 0 8px rgba(2, 168, 164, 0.3);
    transform: scale(1.02);
    /* Expande levemente */
  }

  .form-control:focus {
    border-color: #02A8A4;
    box-shadow: 0 0 5px rgba(2, 168, 164, 0.5);
  }

  /* Botões */
  .btn {
    font-size: 1.5rem;
    padding: 10px 20px;
    border-radius: 8px;
    margin: 5px;
    transition: background-color 0.3s, transform 0.2s;
  }

  .btn-success {
    background-color: #9DED98;
    border: none;
    color: #FFFFFF;
  }

  .btn-success:hover {
    background-color: #7DBBBC;
    transform: scale(1.05);
  }

  .btn-outline-secondary {
    color: #6c757d;
    border: 1px solid #6c757d;
    background-color: transparent;
  }

  .btn-outline-secondary:hover {
    background-color: #C4F2EF;
    color: #333;
    transform: scale(1.05);
  }

  /* Alerta de erro */
  .alert-danger {
    background-color: #F8D7DA;
    border: 1px solid #F5C6CB;
    color: #721C24;
    border-radius: 8px;
    padding: 15px;
    margin-top: 10px;
    font-size: 1.2rem;
  }

  /* Responsividade */
  @media (max-width: 768px) {
    .form-row {
      flex-direction: column;
      /* Torna as colunas verticais em telas menores */
    }

    h1 {
      font-size: 2.5rem;
    }

    .card-header h4 {
      font-size: 1.5rem;
    }

    .btn {
      font-size: 1.3rem;
      padding: 8px 16px;
    }
  }
</style>