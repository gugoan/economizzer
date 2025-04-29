<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<div class="container mt-5">
  <h1 class="text-center mb-4 title-enhanced">Confirmar Transações de Fatura</h1>

  <p class="text-center mb-4 paragraph-enhanced">
    Revise as transações extraídas do PDF. Associe uma categoria e confirme as transações para salvá-las como faturas.
  </p>

  <?php $form = ActiveForm::begin([
    'id' => 'transaction-confirmation-form',
    'action' => Url::to(['fatura-upload/save-faturas', 'id_bancos' => $id_bancos]), // Inclui id_bancos na ação
    'method' => 'post',
    'options' => ['class' => 'form-horizontal'],
  ]); ?>

  <?= Html::hiddenInput('id_bancos', $id_bancos); ?>
  <!-- Campo oculto para id_bancos -->

  <div class="table-responsive">
    <table class="table table-striped table-bordered text-center">
      <thead class="thead-dark">
        <tr>
          <th style="width: 30px;"></th>
          <th style="width: 130px;">Data</th>
          <th style="width: 120px;">Valor</th>
          <th>Descrição</th>
          <th style="width: 150px">Parcelas</th>
          <th style="width: 180px">Categoria</th>
        </tr>
      </thead>
      <tbody id="data-rows">
        <?php foreach ($transactions as $index => $transaction): ?>
        <tr data-index="<?= $index ?>">
          <td>
            <button type="button" class="btn btn-danger btn-sm remove-row" title="Remover">
              <i class="fa fa-trash"></i>
            </button>
          </td>
          <td>
            <?= Html::input('date', "transactions[$index][data]", $transaction['data'] ?? '', [
                'class' => 'form-control input-hover',
                'required' => true,
              ]) ?>
          </td>
          <td>
            <?= Html::input('number', "transactions[$index][valor]", $transaction['valor'] ?? '', [
                'class' => 'form-control input-hover',
                'step' => '0.01',
                'min' => '0',
                'required' => true,
              ]) ?>
          </td>
          <td>
            <?= Html::input('text', "transactions[$index][descricao]", $transaction['descricao'] ?? '', [
                'class' => 'form-control input-hover',
                'required' => true,
              ]) ?>
          </td>
          <td>
            <?= Html::input('text', "transactions[$index][parcelas]", $transaction['parcelas'] ?? '', [
                'class' => 'form-control input-hover',
                'placeholder' => 'Ex: 3/12',
                'required' => true,
              ]) ?>
          </td>
          <td>
            <?= Html::dropDownList(
                "transactions[$index][category_id]",
                $transaction['category_id'] ?? null,
                app\models\Category::getHierarchy(),
                [
                  'prompt' => 'Selecione a categoria',
                  'class' => 'form-control stylish-dropdown',
                  'required' => true,
                ]
              ) ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="form-group text-center mt-4">
    <?= Html::submitButton('<i class="fa fa-check"></i> Confirmar Transações', [
      'class' => 'btn btn-success btn-action',
      'style' => 'padding: 12px 28px; font-size: 1.1em; color: white; border-radius: 30px; box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);',
      'onmouseover' => 'this.style.backgroundColor="#218838"; this.style.transform="scale(1.1)";',
      'onmouseout' => 'this.style.backgroundColor="#28a745"; this.style.transform="scale(1)";',
    ]) ?>
  </div>

  <?php ActiveForm::end(); ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('transaction-confirmation-form');

  form.addEventListener('submit', function(event) {
    const rows = document.querySelectorAll('#data-rows tr');
    let hasNegativeValue = false;

    rows.forEach(function(row) {
      const valueInput = row.querySelector('input[name*="[valor]"]');
      const value = parseFloat(valueInput.value);

      if (value < 0) {
        hasNegativeValue = true;
      }
    });

    if (hasNegativeValue) {
      event.preventDefault();
      alert('Por favor, insira valores não negativos para todas as transações.');
    }
  });

  const rows = document.querySelectorAll('.remove-row');
  rows.forEach(function(button) {
    button.addEventListener('click', function() {
      const row = this.closest('tr');
      row.remove();
    });
  });
});
</script>

<style>
/* Estilo para os inputs ao passar o mouse */
.input-hover {
  transition: background-color 0.3s ease, transform 0.3s ease;
}

.input-hover:hover {
  background-color: #f0f9ff;
  transform: scale(1.05);
}

h1.title-enhanced {
  font-size: 2.2em;
  font-weight: 600;
  color: #2c3e50;
  margin-bottom: 15px;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.paragraph-enhanced {
  font-size: 1.1em;
  color: #34495e;
  line-height: 1.6;
  max-width: 700px;
  margin: 0 auto;
  padding: 10px;
}

.stylish-dropdown {
  background-color: #f8f9fa;
  border: 1px solid #ced4da;
  border-radius: 8px;
  padding: 12px;
  font-size: 1em;
  color: #495057;
  transition: all 0.3s ease;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.stylish-dropdown:hover {
  border-color: #80bdff;
  background-color: #e9ecef;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.stylish-dropdown:focus {
  border-color: #007bff;
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

.table th,
.table td {
  vertical-align: middle;
  text-align: center;
}
</style>