<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<div class="container mt-5">
  <h1 class="text-center mb-4 title-enhanced">Confirmar Transações</h1>

  <p class="text-center mb-4 paragraph-enhanced">
    Revise as transações extraídas do PDF. Insira a categoria e confirme as transações que deseja salvar.
  </p>

  <?php $form = ActiveForm::begin([
    'id' => 'transaction-confirmation-form',
    'action' => Url::to(['pdf-upload/save']),
    'method' => 'post',
    'options' => ['class' => 'form-horizontal'],
  ]); ?>

  <div class="table table-striped table-bordered">
    <table class="table table-striped table-bordered">
      <thead class="thead-dark">
        <tr>
          <th style="width: 30px;"></th>
          <th style="width: 130px;">Data</th>
          <th style="width: 120px;">Valor</th>
          <th>Descrição</th>
          <th style="width: 180px">Categoria</th>
          <th style="width: 140px">Tipo</th>
          <th style="width: 50px">Pendente</th>
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
              <?= Html::input('text', "transactions[$index][date]", $transaction['date'], ['readonly' => true, 'class' => 'form-control input-hover']) ?>
            </td>
            <td>
              <?= Html::input('number', "transactions[$index][value]", $transaction['value'], ['class' => 'form-control input-hover', 'min' => '0']) ?>
            </td>
            <td>
              <?= Html::input('text', "transactions[$index][description]", $transaction['description'], ['class' => 'form-control input-hover']) ?>
            </td>
            <td>
              <?= Html::dropDownList(
                "transactions[$index][category_id]",
                $transaction['category_id'] ?? null,
                app\models\Category::getHierarchy(),
                [
                  'prompt' => Yii::t('app', 'Selecione a categoria'),
                  'class' => 'form-control stylish-dropdown'
                ]
              ) ?>
            </td>
            <td>
              <?= Html::dropDownList(
                "transactions[$index][type_id]",
                $transaction['type_id'] ?? null,
                [1 => 'Receita', 2 => 'Despesa'],
                ['class' => 'form-control input-hover']
              ) ?>
            </td>
            <td>
              <?= $form->field($model, "transactions[$index][is_pending]")->checkbox([
                'label' => '',
                'labelOptions' => ['class' => 'custom-control-label'],
                'class' => 'custom-control-input input-hover',
              ]) ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="form-group text-center mt-4" style="position: sticky; bottom: 20px; z-index: 1000;">
    <?= Html::submitButton('<i class="fa fa-check"></i> Confirmar Transações', [
      'class' => 'btn',
      'style' => 'padding: 12px 28px; font-size: 1.1em; color: white; background-color: #28a745; border-radius: 30px; transition: background-color 0.3s, transform 0.3s; box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);',
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
        const valueInput = row.querySelector('input[name*="[value]"]');
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
    /* Cor de fundo ao passar o mouse */
    transform: scale(1.05);
    /* Aumenta o input em 5% */
  }


  h1 {
    color: #343a40;
  }

  .table th,
  .table td {
    vertical-align: middle;
    text-align: center;
    align-items: center;
    justify-content: center;
  }

  .btn {
    margin: 0 5px;
  }

  .input-center {
    margin: auto;
    text-align: center;
  }

  /* Estilo do dropdown */
  .stylish-dropdown {
    background-color: #f8f9fa;
    /* Cor de fundo clara */
    border: 1px solid #ced4da;
    /* Borda padrão */
    border-radius: 8px;
    /* Bordas arredondadas */
    padding: 12px;
    /* Espaçamento interno */
    font-size: 1em;
    /* Tamanho da fonte */
    color: #495057;
    /* Cor do texto */
    transition: all 0.3s ease;
    /* Transições suaves */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    /* Sombra suave */
    outline: none;
    /* Remove a borda padrão de foco */
  }

  /* Estilo ao passar o mouse */
  .stylish-dropdown:hover {
    border-color: #80bdff;
    /* Cor da borda ao passar o mouse */
    background-color: #e9ecef;
    /* Cor de fundo ao passar o mouse */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    /* Sombra mais intensa ao passar o mouse */
  }

  /* Estilo para o dropdown em foco */
  .stylish-dropdown:focus {
    border-color: #007bff;
    /* Cor da borda em foco */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    /* Sombra azul em foco */
  }

  /* Estilo do placeholder */
  .stylish-dropdown option[value=""] {
    color: #6c757d;
    /* Cor do texto do placeholder */
  }

  /* Estilo do título */
  .title-enhanced {
    font-size: 2.2em;
    /* Tamanho da fonte */
    font-weight: 600;
    /* Peso do texto */
    color: #2c3e50;
    /* Cor do texto */
    margin-bottom: 15px;
    /* Margem inferior */
    text-transform: uppercase;
    /* Letras maiúsculas */
    letter-spacing: 1px;
    /* Espaçamento entre letras */
  }

  /* Estilo do parágrafo */
  .paragraph-enhanced {
    font-size: 1.1em;
    /* Tamanho da fonte */
    color: #34495e;
    /* Cor do texto */
    line-height: 1.6;
    /* Espaçamento entre linhas */
    max-width: 700px;
    /* Largura máxima */
    margin: 0 auto;
    /* Centraliza o parágrafo */
    padding: 10px;
    /* Espaçamento interno */
  }
</style>