<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\Faturas;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BancosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bancos';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bancos-index container-fluid">

  <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
  <div class="alert alert-dismissible alert-<?= substr($key, strpos($key, '-') + 1) ?>" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <p><?= $message ?></p>
  </div>
  <?php endforeach; ?>

  <div class="d-flex justify-content-between align-items-center mb-4">


    <div class="d-flex justify-content-end mb-3"></div>
    <h1 class="flex-grow-1 text-center"><?= Html::encode($this->title) ?>

    </h1>
    <div class="btn-group ms-3" role="group">
      <?= Html::a('Adicionar Banco', ['create'], ['class' => 'btn btn-primary me-2']) ?>
      <?= Html::a('Listar Faturas', ['faturas/index'], ['class' => 'btn btn-outline-secondary']) ?>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchModal">
        Pesquisar Bancos
      </button>
    </div>
    <!-- Botão que aciona o modal -->

  </div>

  <!-- Renderização do modal de busca -->
  <?= $this->render('_search', ['searchModel' => $searchModel]); ?>

  <!-- Tabela de Bancos -->
  <div class="card mb-4">
    <div class="card-header bg-primary text-white">
      <h3 class="mb-0">Bancos Cadastrados</h3>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th style="width: 30px;">#</th>
              <th style="width: 100px;">Nome do Banco</th>
              <th>Descrição</th>
              <th style="width: 90x;">Data de Registro</th>
              <th>Data Iinicio</th>
              <th>Data fechamento</th>
              <th style="width: 150px;">Ações</th>
              <th style="width: 130px;">Adicionar Fatura</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($dataProvider->models as $index => $banco): ?>
            <tr class="clickable-row" data-id="<?= $banco->id_bancos ?>">
              <td><?= $index + 1 ?></td>
              <td>
                <?= Html::a(Html::encode($banco->nome), ['view', 'id' => $banco->id_bancos], [
                    'class' => 'text-decoration-none text-primary',
                  ]) ?>
              </td>

              <td><?= Html::encode($banco->descricao) ?></td>
              <td><?= Yii::$app->formatter->asDate($banco->data_registro, 'php:d/m/Y') ?></td>
              <td>
                <?= $banco->data_inicio_cartao ? Yii::$app->formatter->asDate($banco->data_inicio_cartao, 'php:d') : 'N/A' ?>
              </td>
              <td>
                <?= $banco->data_fechamento_cartao ? Yii::$app->formatter->asDate($banco->data_fechamento_cartao, 'php:d') : 'N/A' ?>
              </td>
              <td>
                <?= Html::a('<i class="fa fa-eye"></i>', ['view', 'id' => $banco->id_bancos], [
                    'class' => 'btn btn-info btn-sm',
                    'title' => 'Visualizar Banco',
                    'style' => 'font-size: 1rem',
                    'data-toggle' => 'tooltip'
                  ]) ?>
                <?= Html::a('<i class="fa fa-pencil-alt"></i>', ['update', 'id' => $banco->id_bancos], [
                    'class' => 'btn btn-primary btn-sm',
                    'title' => 'Editar Banco',
                    'style' => 'font-size: 1rem',
                    'data-toggle' => 'tooltip'
                  ]) ?>
                <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $banco->id_bancos], [
                    'class' => 'btn btn-danger btn-sm',
                    'title' => 'Excluir Banco',
                    'data-confirm' => 'Tem certeza de que deseja excluir este banco?',
                    'data-method' => 'post',
                    'style' => 'font-size: 1rem',
                    'data-toggle' => 'tooltip'
                  ]) ?>
              </td>
              <td>

                <?= Html::a('<i class="fa fa-upload"></i>', ['fatura-upload/upload-faturas', 'id_bancos' => $banco->id_bancos], [
                    'class' => 'btn btn-secondary',
                    'title' => 'Upload Faturas',
                    'style' => 'font-size: 1rem',
                    'data-toggle' => 'tooltip'
                  ]) ?>
                <?= Html::a('<i class="fa fa-plus"></i>', ['faturas/create', 'id_bancos' => $banco->id_bancos], [
                    'class' => 'btn btn-success btn-sm',
                    'title' => 'Criar Faturas',
                    'style' => 'font-size: 1rem',
                    'data-toggle' => 'tooltip'
                  ]) ?>
              </td>

            <tr id="faturas-<?= $banco->id_bancos ?>" class="fatura-row" style="display: none;">
              <td colspan="8">
                <!-- Abas de Ano -->
                <ul class="nav nav-pills mb-3" id="yearTabs" role="tablist">
                  <?php for ($year = date('Y'); $year >= 2023; $year--): ?>
                  <li class="nav-item">
                    <a class="nav-link <?= $year == $selectedYear ? 'active' : '' ?>" id="tab-<?= $year ?>"
                      href="?ano=<?= $year ?>&id=<?= $banco->id_bancos ?>" role="tab">
                      <?= $year ?>
                    </a>
                  </li>
                  <?php endfor; ?>
                </ul>

                <div class="card mt-2">
                  <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Faturas Associadas ao Banco: <?= Html::encode($banco->nome) ?> E ao Ano:
                      <?= $selectedYear ?></h5>
                  </div>
                  <div class="card-body">
                    <!-- Adicionar abas para os meses -->
                    <ul class="nav nav-tabs" id="tab-<?= $banco->id_bancos ?>" role="tablist">
                      <?php
                        $selectedYear = Yii::$app->request->get('ano', date('Y'));
                        $months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
                        foreach ($months as $i => $month):
                        ?>
                      <li class="nav-item">
                        <a class="nav-link <?= $i === 0 ? 'active' : '' ?>"
                          id="tab-<?= $month ?>-<?= $banco->id_bancos ?>" data-toggle="tab"
                          href="#content-<?= $month ?>-<?= $banco->id_bancos ?>" role="tab"><?= $month ?></a>
                      </li>
                      <?php endforeach; ?>
                    </ul>

                    <div class="tab-content">
                      <?php foreach ($months as $i => $month): ?>
                      <div class="tab-pane fade <?= $i === 0 ? 'show active' : '' ?>"
                        id="content-<?= $month ?>-<?= $banco->id_bancos ?>" role="tabpanel">
                        <div class="table-responsive">
                          <table class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>Descrição</th>
                                <th style="width: 100px;">Data</th>
                                <th style="width: 110px;">Valor</th>
                                <th style="width: 90px;">Parcelas</th>
                                <th style="width: 130px;">Categoria</th>
                                <th style="width: 150px;">Ações</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                  $startDate = new DateTime("$selectedYear-$i-01");
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
                                  <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['faturas/view', 'id' => $fatura->id_fatura], [
                                            'class' => 'btn btn-info btn-sm',
                                            'title' => 'Visualizar',
                                            'style' => 'font-size: 1rem',
                                            'data-toggle' => 'tooltip'
                                          ]) ?>
                                  <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['faturas/update', 'id' => $fatura->id_fatura], [
                                            'class' => 'btn btn-primary btn-sm',
                                            'title' => 'Editar',
                                            'style' => 'font-size: 1rem',
                                            'data-toggle' => 'tooltip'
                                          ]) ?>
                                  <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['faturas/delete', 'id' => $fatura->id_fatura], [
                                            'class' => 'btn btn-danger btn-sm btn-delete-fatura',
                                            'data-method' => 'post',
                                            'title' => 'Excluir',
                                            'style' => 'font-size: 1rem',
                                            'data-toggle' => 'tooltip'
                                          ]) ?>
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

                        <!-- Resumo Detalhado -->
                        <div class="card mt-2">
                          <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">Resumo Detalhado do Banco: <?= Html::encode($banco->nome) ?> -
                              <?= $month ?> <?= $selectedYear ?></h5>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-6">
                                <ul class="list-group">
                                  <li class="list-group-item">
                                    <strong>Total de Faturas:</strong> <?= count($faturasPorMes) ?>
                                  </li>
                                  <li class="list-group-item">
                                    <strong>Valor Total de Faturas:</strong>
                                    <?= Yii::$app->formatter->asCurrency(array_sum(ArrayHelper::getColumn($faturasPorMes, 'valor'))) ?>
                                  </li>
                                  <li class="list-group-item">
                                    <strong>Total de Parcelas:</strong>
                                    <?= array_sum(ArrayHelper::getColumn($faturasPorMes, 'parcelas')) ?>
                                  </li>
                                </ul>
                              </div>
                              <div class="col-md-6">
                                <ul class="list-group">
                                  <li class="list-group-item">
                                    <strong>Média de Valor por Fatura:</strong>
                                    <?= count($faturasPorMes) > 0 ? Yii::$app->formatter->asCurrency(array_sum(ArrayHelper::getColumn($faturasPorMes, 'valor')) / count($faturasPorMes)) : 'N/A' ?>
                                  </li>
                                  <li class="list-group-item">
                                    <strong>Maior Fatura:</strong>
                                    <?= !empty($faturasPorMes) ? Yii::$app->formatter->asCurrency(max(ArrayHelper::getColumn($faturasPorMes, 'valor'))) : 'N/A' ?>
                                  </li>
                                  <li class="list-group-item">
                                    <strong>Menor Fatura:</strong>
                                    <?= !empty($faturasPorMes) ? Yii::$app->formatter->asCurrency(min(ArrayHelper::getColumn($faturasPorMes, 'valor'))) : 'N/A' ?>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div class="card-footer text-center">
                            <small class="text-muted">Resumo baseado em dados das faturas associadas ao mês de
                              <?= $month ?>.</small>
                          </div>
                        </div>
                      </div>


                      <?php endforeach; ?>
                    </div>

                  </div>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<script>
$(document).ready(function() {});

document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.nav-link').forEach(function(link) {
    link.addEventListener('click', function() {
      // Remover a classe 'show active' de todas as abas
      document.querySelectorAll('.tab-pane').forEach(function(tab) {
        tab.classList.remove('show', 'active');
      });

      // Adicionar a classe 'show active' à aba correspondente
      const targetId = this.getAttribute('href').substring(1);
      document.getElementById(targetId).classList.add('show', 'active');
    });
  });
});

$(document).ready(function() {
  $('[data-toggle="tooltip"]').tooltip();
});
$(document).on('click', '.pagination a, th a', function(event) {
  event.preventDefault();
  $.get($(this).attr('href'), function(response) {
    $('.bancos-index .card-body').html($(response).find('.bancos-index .card-body').html());
  });
});

document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.btn-delete-fatura').forEach(function(button) {
    button.addEventListener('click', function(event) {
      event.preventDefault(); // Previne o redirecionamento padrão
      if (confirm('Tem certeza que deseja excluir esta fatura?')) {
        fetch(this.href, {
            method: 'POST',
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'X-CSRF-Token': yii.getCsrfToken()
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert(data.message);
              location.reload(); // Atualiza a página
            } else {
              alert('Ocorreu um erro ao excluir a fatura.');
            }
          })
          .catch(error => {
            console.error('Erro:', error);
            alert('Ocorreu um erro ao processar a solicitação.');
          });
      }
    });
  });
});


document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.clickable-row').forEach(function(row) {
    row.addEventListener('click', function() {
      const id = this.getAttribute('data-id');
      const detailRow = document.getElementById('faturas-' + id);

      if (detailRow.style.display === 'none' || detailRow.style.display === '') {
        detailRow.style.display = 'table-row';
      } else {
        detailRow.style.display = 'none';
      }
    });
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

.container-fluid {
  padding: 20px;
  background-color: #FFFFFF;
  /* Fundo principal branco */
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  max-width: 100%;
  /* Garante que o contêiner não ultrapasse a largura da página */
  overflow-x: hidden;
  /* Evita rolagem horizontal */
}

/* Cabeçalho */
h1 {
  font-size: 3.5rem;
  font-weight: bold;
  text-align: center;
  margin-bottom: 20px;
  color: #02A8A4;
  /* Cor de destaque */
}

/* Botões */
.btn-group {
  font-size: 2rem;
  display: flex;
  justify-content: center;
  /* Centraliza os botões */
  flex-wrap: wrap;

}

.btn {
  border-radius: 8px;
  margin: 5px;
  transition: transform 0.2s, background-color 0.3s, color 0.3s;

  text-align: center;
}

.btn:hover {
  transform: scale(1.05);
}

.btn-primary {
  background-color: #02A8A4;
  /* Botão com cor de destaque */
  border-color: #02A8A4;
  color: #FFFFFF;
}

.btn-primary:hover {
  background-color: #05A796;
  /* Efeito de hover */
}


/* Botões de ação */
.btn-action {
  border-radius: 50%;
  /* Botões circulares */
  margin: 5px;
  font-size: 1.2rem;
  width: 40px;
  height: 40px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background-color: #02A8A4;
  /* Cor uniforme */
  color: #FFFFFF;
}

.btn-action:hover {
  background-color: #05A796;
}

/* Tabela */
.table {
  width: 98%;
  /* Garante que a tabela preencha todo o espaço disponível */
  margin: 0 auto;
  border-collapse: collapse;
  border: 1px solid #E0E0E0;
  /* Bordas sutis */
  table-layout: fixed;
  /* Garante que as células tenham uma largura uniforme */
  overflow: hidden;
  /* Evita rolagem */
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
  /* Cor de fundo ao passar o mouse */
  transform: scale(1.01);
  /* Aumentar o tamanho da linha */
  transition: background-color 0.3s, transform 0.3s;
  /* Transição suave */
}

.table thead th {
  background-color: #05A796;
  /* Cabeçalho elegante */
  color: #FFFFFF;
  font-size: 1rem;
}

.table tbody tr:nth-child(even) {
  background-color: #FFFFFF;
}

.table tbody tr:nth-child(odd) {
  background-color: #F2F2F2;
}

/* Cartões */
.card {
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  margin-bottom: 20px;
}

.card-header {
  background-color: #02A8A4;
  color: #F1f1f1;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
  font-size: 1.5rem;
  text-align: center;
}

.card-footer {
  background-color: #F1F1F1;
  color: #6c757d;
}

/* Lista de Resumo */
.list-group-item {
  border: none;
  background-color: #FFFFFF;
  font-size: 1.5rem;
  text-align: center;
}

.list-group-item strong {
  font-weight: 600;
}

/* Modal */
.modal-content {
  border-radius: 8px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.modal-header {
  background-color: #05A796;
  color: #FFFFFF;
  border-top-left-radius: 8px;
  border-top-right-radius: 8px;
}

.modal-title {
  font-size: 1.5rem;
  text-align: center;
}

.modal-body {
  padding: 20px;
}

.close {
  color: #FFFFFF;
}

/* Abas */
.nav-tabs {
  border-bottom: 2px solid #05A796;
  display: flex;
  justify-content: center;
}

.nav-tabs .nav-link {
  color: #05A796;
  border-radius: 10px;
  font-size: 1.5rem;
  margin: 2px;
  padding: 8px 12px;
  transition: background-color 0.3s, color 0.3s;
}

.nav-tabs .nav-link.active {
  background-color: #02A8A4;
  color: #FFFFFF;
}

.nav-tabs .nav-link:hover {
  background-color: #C4F2EF;
  color: #333;
}

.tab-content .tab-pane {
  padding: 15px;
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

/* Efeitos de Hover e Expansão */
.btn:hover,
.table-hover tr:hover {
  cursor: pointer;
}

.modal {
  z-index: 1050 !important;
}

.modal-backdrop {
  z-index: 1040 !important;
}

/* Estilo para a escolha do ano */
.nav-pills {
  border-bottom: 2px solid #05A796;
  display: flex;
  justify-content: center;
  margin-bottom: 20px;
  /* Espaço entre as abas e o conteúdo */
}

.nav-pills .nav-link {
  color: #05A8A4;
  border-radius: 10px;
  font-size: 1.5rem;
  margin: 2px;
  padding: 8px 12px;
  transition: background-color 0.3s, color 0.3s;
  text-align: center;
}

.nav-pills .nav-link.active {
  background-color: #02A8A4;
  color: #FFFFFF;
}

.nav-pills .nav-link:hover {
  background-color: #C4F2EF;
  color: #333;
}

/* Responsividade */
@media (max-width: 768px) {
  .btn {
    margin-bottom: 10px;
  }

  h1 {
    font-size: 2rem;
  }

  .modal-title {
    font-size: 1.3rem;
  }
}
</style>