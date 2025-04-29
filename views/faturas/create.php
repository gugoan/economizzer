<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $fatura app\models\Faturas */

$this->title = 'Adicionar Fatura';
$this->params['breadcrumbs'][] = ['label' => 'Bancos', 'url' => ['bancos/index']];
$this->params['breadcrumbs'][] = ['label' => $fatura->banco->nome, 'url' => ['bancos/view', 'id' => $fatura->id_bancos]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="faturas-create container mt-5">
  <div class="card shadow-lg">
    <div class="card-header text-center bg-primary text-white">
      <h4 style="font-size: 1.8rem;"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="card-body p-5">
      <?php $form = ActiveForm::begin(); ?>

      <!-- Campo Banco (somente exibição) -->
      <div class="form-group mb-4 text-center">
        <label style="font-size: 1.5rem; color: #007bff; font-weight: bold;">Banco</label>
        <p class="form-control-plaintext text-primary" style="font-size: 1.4rem; font-weight: bold;">
          <?= Html::encode($fatura->banco->nome) ?></p>
      </div>

      <div class="row text-center">
        <!-- Campo Descrição -->
        <div class="col-md-6 form-group mb-4">
          <?= $form->field($fatura, 'descricao')
            ->textInput([
              'maxlength' => true,
              'placeholder' => 'Ex: Compra mercado',
              'class' => 'form-control styled-input text-center'
            ])
            ->label('Descrição', ['class' => 'font-weight-bold', 'style' => 'font-size: 1.3rem; color: #333;']) ?>
        </div>

        <!-- Campo Data -->
        <div class="col-md-6 form-group mb-4">
          <?= $form->field($fatura, 'data')
            ->input('date', ['class' => 'form-control styled-input text-center'])
            ->label('Data da Fatura', ['class' => 'font-weight-bold', 'style' => 'font-size: 1.3rem; color: #333;']) ?>
        </div>
      </div>

      <div class="row text-center">
        <!-- Campo Parcelas -->
        <div class="col-md-6 form-group mb-4">
          <?= $form->field($fatura, 'parcelas')
            ->textInput([
              'placeholder' => 'Ex: 3/12 para 3ª parcela de 12',
              'class' => 'form-control styled-input text-center'
            ])
            ->label('Parcelas', ['class' => 'font-weight-bold', 'style' => 'font-size: 1.3rem; color: #333;']) ?>
        </div>

        <!-- Campo Valor -->
        <div class="col-md-6 form-group mb-4">
          <?= $form->field($fatura, 'valor')
            ->textInput([
              'type' => 'number',
              'step' => '0.01',
              'placeholder' => 'Ex: 150.75',
              'class' => 'form-control styled-input text-center'
            ])
            ->label('Valor (R$)', ['class' => 'font-weight-bold', 'style' => 'font-size: 1.3rem; color: #333;']) ?>
        </div>
      </div>

      <div class="row text-center">
        <!-- Campo Categoria -->
        <div class="col-md-6 form-group mb-4">
          <?= $form->field($fatura, 'category_id')
            ->dropDownList(app\models\Category::getHierarchy(), [
              'prompt' => 'Selecione a categoria',
              'class' => 'form-control stylish-dropdown styled-input text-center'
            ])
            ->label('Categoria', ['class' => 'font-weight-bold', 'style' => 'font-size: 1.3rem; color: #333;']) ?>
        </div>
      </div>

      <!-- Botões de ação -->
      <div class="form-group text-center mt-4">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary btn-action me-2']) ?>
        <?= Html::a('Cancelar', ['bancos/view', 'id' => $fatura->id_bancos], ['class' => 'btn btn-secondary btn-action']) ?>
      </div>

      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>
<style>
  /* Reset CSS para uma base uniforme */
  *,
  *::before,
  *::after {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
</style>