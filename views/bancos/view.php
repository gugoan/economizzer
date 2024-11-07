<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;
use app\models\Faturas;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $banco app\models\Bancos */
/* @var $searchModelFaturas app\models\FaturasSearch */
/* @var $selectedYear integer */

$this->title = $banco->nome;
$this->params['breadcrumbs'][] = ['label' => 'Bancos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bancos-view container mt-5">

  <!-- Modal para Detalhes do Banco -->
  <div class="modal fade" id="bankDetailsModal" tabindex="-1" aria-labelledby="bankDetailsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="bankDetailsModalLabel">Detalhes do Banco</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?= DetailView::widget([
            'model' => $banco,
            'options' => ['class' => 'table table-borderless'],
            'attributes' => [
              'id_bancos',
              'nome',
              'descricao',
              [
                'attribute' => 'data_registro',
                'format' => ['date', 'php:d/m/Y'],
                'label' => 'Data de Registro',
              ],
              [
                'attribute' => 'data_inicio_cartao',
                'format' => ['date', 'php:d/m/Y'],
                'label' => 'Data de Início do Cartão',
              ],
              [
                'attribute' => 'data_fechamento_cartao',
                'format' => ['date', 'php:d/m/Y'],
                'label' => 'Data de Fechamento do Cartão',
              ],
              [
                'attribute' => 'user_id',
                'label' => 'Usuário',
                'value' => $banco->user->username,
              ],
              [
                'attribute' => 'total_faturas',
                'label' => 'Total de Faturas',
                'value' => count($banco->faturas),
              ],
              [
                'attribute' => 'valor_total_faturas',
                'label' => 'Valor Total das Faturas',
                'value' => Yii::$app->formatter->asCurrency(array_sum(ArrayHelper::getColumn($banco->faturas, 'valor'))),
              ],
            ]
          ]) ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Botão para abrir o modal de detalhes -->
  <div class="text-center mb-4">
    <h1 class="display-5 text-primary mb-3"><?= Html::encode($this->title) ?></h1>
    <div class="btn-group" role="group">
      <?= Html::a('Atualizar', ['update', 'id' => $banco->id_bancos], ['class' => 'btn btn-outline-primary']) ?>
      <?= Html::a('Excluir', ['delete', 'id' => $banco->id_bancos], [
        'class' => 'btn btn-outline-danger',
        'data-confirm' => 'Tem certeza de que deseja excluir este banco?',
        'data-method' => 'post',
      ]) ?>
      <?= Html::a('<i class="fa fa-upload"></i> Upload PDF', ['fatura-upload/upload-faturas', 'id_bancos' => $banco->id_bancos], [
        'class' => 'btn btn-outline-secondary',
      ]) ?>
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#bankDetailsModal">
        Ver Detalhes do Banco
      </button>
    </div>
  </div>

  <!-- Abas de Ano -->
  <ul class="nav nav-pills mb-3" id="yearTabs" role="tablist">
    <?php for ($year = date('Y'); $year >= 2023; $year--): ?>
    <li class="nav-item">
      <a class="nav-link year-tab <?= $year == $selectedYear ? 'active' : '' ?>" data-year="<?= $year ?>"
        id="tab-<?= $year ?>" href="javascript:void(0);" role="tab">
        <?= $year ?>
      </a>
    </li>
    <?php endfor; ?>
  </ul>

  <!-- Faturas Associadas com Abas por Mês -->
  <div class="card shadow-sm border-1">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">Faturas Associadas - Ano: <?= $selectedYear ?></h5>
    </div>
    <div class="card-body p-0">
      <ul class="nav nav-tabs" id="faturasTabs" role="tablist">
        <?php
        $months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
        foreach ($months as $i => $month):
        ?>
        <li class="nav-item">
          <a class="nav-link <?= $i === 0 ? 'active' : '' ?>" id="tab-<?= $month ?>" data-toggle="tab"
            href="#content-<?= $month ?>" role="tab" aria-controls="content-<?= $month ?>">
            <?= $month ?>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>

      <div class="tab-content">
        <?php foreach ($months as $i => $month): ?>
        <div class="tab-pane fade <?= $i === 0 ? 'show active' : '' ?>" id="content-<?= $month ?>" role="tabpanel"
          aria-labelledby="tab-<?= $month ?>">
          <div class="table-responsive mt-3">
            <table class="table table-bordered table-hover mb-0">
              <thead>
                <tr>
                  <th>Descrição</th>
                  <th>Data</th>
                  <th>Valor</th>
                  <th>Parcelas</th>
                  <th>Categoria</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $monthIndex = $i + 1; // Corrigir o índice para começar de 1 (Janeiro)
                  $startDate = new DateTime("$selectedYear-$monthIndex-01");
                  $endDate = clone $startDate;
                  $endDate->modify('last day of this month');

                  $faturasPorMes = Faturas::find()
                    ->where(['id_bancos' => $banco->id_bancos])
                    ->andWhere(['between', 'data', $startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                    ->all();

                  if (!empty($faturasPorMes)) {
                    foreach ($faturasPorMes as $fatura): ?>
                <tr>
                  <td><?= Html::encode($fatura->descricao) ?></td>
                  <td><?= Yii::$app->formatter->asDate($fatura->data, 'php:d/m/Y') ?></td>
                  <td><?= Yii::$app->formatter->asCurrency($fatura->valor) ?></td>
                  <td><?= Html::encode($fatura->parcelas) ?></td>
                  <td><?= Html::encode($fatura->category->desc_category ?? 'N/A') ?></td>
                  <td>
                    <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['faturas/view', 'id' => $fatura->id_fatura], ['class' => 'btn btn-info btn-sm', 'title' => 'Visualizar']) ?>
                    <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['faturas/update', 'id' => $fatura->id_fatura], ['class' => 'btn btn-primary btn-sm', 'title' => 'Editar']) ?>
                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['faturas/delete', 'id' => $fatura->id_fatura], ['class' => 'btn btn-danger btn-sm', 'title' => 'Excluir', 'data-confirm' => 'Tem certeza de que deseja excluir esta fatura?', 'data-method' => 'post']) ?>
                  </td>
                </tr>
                <?php endforeach;
                  } else { ?>
                <tr>
                  <td colspan="6" class="text-center">Nenhuma fatura para <?= $month ?>.</td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  $('.year-tab').on('click', function() {
    var year = $(this).data('year');
    $('.year-tab').removeClass('active');
    $(this).addClass('active');

    // Atualizar o título do ano selecionado
    $('.card-header h5').text('Faturas Associadas - Ano: ' + year);

    // Atualizar o conteúdo das faturas via AJAX
    $.ajax({
      url: '<?= \yii\helpers\Url::to(['bancos/view']) ?>',
      method: 'GET',
      data: {
        ano: year,
        id: <?= $banco->id_bancos ?>
      },
      success: function(response) {
        // Atualiza a parte da página onde as faturas são exibidas
        $('.tab-content').html($(response).find('.tab-content').html());
      },
      error: function() {
        alert('Erro ao carregar as faturas.');
      }
    });
  });

  // Corrigir problema de abas ativas
  $('#faturasTabs .nav-link').on('click', function() {
    $('#faturasTabs .nav-link').removeClass('active');
    $(this).addClass('active');
    $('.tab-pane').removeClass('show active');
    var targetId = $(this).attr('href');
    $(targetId).addClass('show active');
  });
});
</script>

<style>
/* Estilos Gerais */
body {
  background-color: #F2F2F2;
  /* Fundo neutro */
  font-family: 'Arial', sans-serif;
  font-size: 1.5rem;
  margin: 0;
  padding: 0;
  overflow-x: hidden;
  /* Evita rolagem horizontal */
}

.container {
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  max-width: 100%;
  margin: 0 auto;
  text-align: center;
  /* Centraliza o texto */
  overflow: hidden;
  /* Evita rolagem horizontal */
}

h1 {
  font-size: 3.5rem;
  font-weight: bold;
  color: #02A8A4;
  /* Cor de destaque */
  margin-bottom: 20px;
  text-align: center;
}

.card {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  width: 98%;
  margin: 0 auto;
}

.btn-group {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  font-size: 1.5rem;
}

.btn {
  border-radius: 8px;
  margin: 5px;
  transition: transform 0.2s, background-color 0.3s, color 0.3s;
}

.btn:hover {
  transform: scale(1.05);
}

.btn-outline-primary {
  border-color: #02A8A4;
  color: #02A8A4;
}

.btn-outline-primary:hover {
  background-color: #C4F2EF;
  color: #333;
}

.btn-info {
  background-color: #9DED98;
  color: #FFFFFF;
  border: none;
}

.btn-info:hover {
  background-color: #7DBBBC;
  transform: scale(1.05);
}

.btn-outline-danger {
  border-color: #dc3545;
  color: #dc3545;
}

.btn-outline-danger:hover {
  background-color: #F8D7DA;
  color: #721C24;
}

/* Modal */
.modal-content {
  border-radius: 12px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
  background-color: #FFFFFF;
}

.modal-header {
  background-color: #05A796;
  color: #FFFFFF;
  border-top-left-radius: 12px;
  border-top-right-radius: 12px;
  display: flex;
  justify-content: center;
  /* Centraliza o título */
}

.modal-title {
  font-size: 2rem;
  text-align: center;
}

.close {
  color: #FFFFFF;
}

.modal-body {
  padding: 20px;
  text-align: center;
  /* Centraliza o texto */
}

.modal-footer {
  display: flex;
  justify-content: center;
  gap: 10px;
  background-color: #F2F2F2;
  border-bottom-left-radius: 12px;
  border-bottom-right-radius: 12px;
}

/* Tabela */
.table {
  width: 98%;
  /* Ajusta a largura da tabela */
  margin: 0 auto;
  border-collapse: collapse;
  table-layout: fixed;
  /* Garante que as células tenham largura fixa */
  border: 1px solid #E0E0E0;
  /* Bordas sutis */
}

.table th,
.table td {
  text-align: center;
  vertical-align: middle;
  padding: 15px;
  font-size: 1.5rem;
  border: 1px solid #E0E0E0;
  word-wrap: break-word;
  /* Quebra o texto se for muito longo */
}

.table-hover tbody tr:hover {
  background-color: #C4F2EF;
  transform: scale(1.01);
  transition: background-color 0.3s, transform 0.3s;
}

.table thead th {
  background-color: #05A796;
  color: #FFFFFF;
  font-size: 1rem;
}

.table tbody tr:nth-child(even) {
  background-color: #FFFFFF;
}

.table tbody tr:nth-child(odd) {
  background-color: #F2F2F2;
}

/* Abas */
.nav-tabs,
.nav-pills {
  border-bottom: 2px solid #05A796;
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  margin-bottom: 0;
}

.nav-tabs .nav-link,
.nav-pills .nav-link {
  color: #05A8A4;
  border-radius: 10px;
  font-size: 1.5rem;
  margin: 2px;
  padding: 8px 12px;
  transition: background-color 0.3s, color 0.3s;
  text-align: center;
}

.nav-tabs .nav-link.active,
.nav-pills .nav-link.active {
  background-color: #02A8A4;
  color: #FFFFFF;
}

.nav-tabs .nav-link:hover,
.nav-pills .nav-link:hover {
  background-color: #C4F2EF;
  color: #333;
}

.tab-content .tab-pane {
  padding: 0;
  /* Remove padding extra */
}

/* Tooltip */
.tooltip-inner {
  background-color: #444;
  color: #FFFFFF;
  padding: 8px;
  border-radius: 4px;
  font-size: 1rem;
}

/* Alerta */
.alert-dismissible .close {
  position: absolute;
  top: 0;
  right: 10px;
  color: inherit;
}

.alert {
  border-radius: 5px;
  margin-bottom: 20px;
}

/* Responsividade */
@media (max-width: 768px) {
  .btn {
    margin-bottom: 10px;
  }

  h1 {
    font-size: 2.5rem;
  }

  .modal-title {
    font-size: 1.3rem;
  }

  .btn-group .btn {
    font-size: 1.3rem;
  }

  .nav-tabs .nav-link,
  .nav-pills .nav-link {
    font-size: 1.3rem;
    padding: 6px 10px;
  }
}
.modal {
  z-index: 1050 !important;
}

.modal-backdrop {
  z-index: 1040 !important;
}
</style>