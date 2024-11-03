<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\Bancos;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FaturasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $selectedMonth integer */
/* @var $selectedYear integer */

$this->title = 'Faturas';
$this->params['breadcrumbs'][] = $this->title;

// Cálculo do valor total e média por categoria
$totalValor = 0;
$categoriaValores = [];
$categoriaNomes = [];

foreach ($dataProvider->getModels() as $fatura) {
  $totalValor += $fatura->valor;
  $categoriaValores[$fatura->category_id][] = $fatura->valor;
  $categoriaNomes[$fatura->category_id] = $fatura->category->desc_category;
}

// Calcular a média por categoria
$mediaPorCategoria = [];
foreach ($categoriaValores as $categoriaId => $valores) {
  $mediaPorCategoria[$categoriaId] = [
    'media' => array_sum($valores) / count($valores),
    'desc_category' => $categoriaNomes[$categoriaId]
  ];
}
?>

<div class="faturas-index container">

  <!-- Título da Página e Botão de Adicionar Fatura -->
  <div class="d-flex align-items-center mb-4">
    <h1 class="flex-grow-1 text-center"><?= Html::encode($this->title) ?></h1>
    <div class="text-right mb-4">
      <?= Html::a('Adicionar Fatura', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
      <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#resumoModal">
        Resumo Total
      </button>
    </div>
  </div>

  <!-- Modal de Resumo -->
  <div class="modal fade" id="resumoModal" tabindex="-1" aria-labelledby="resumoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="resumoModalLabel">Resumo de Faturas</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row text-center">
            <div class="col-md-4">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h6 class="card-title font-weight-bold">Total de Faturas</h6>
                  <p class="card-text display-4"><?= $dataProvider->getTotalCount() ?></p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h6 class="card-title font-weight-bold">Valor Total</h6>
                  <p class="card-text text-success display-4"><?= Yii::$app->formatter->asCurrency($totalValor) ?></p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h6 class="card-title font-weight-bold">Média por Categoria</h6>
                  <?php foreach ($mediaPorCategoria as $categoria): ?>
                  <p class="card-text"><?= Html::encode($categoria['desc_category']) ?>:
                    <strong><?= Yii::$app->formatter->asCurrency($categoria['media']) ?></strong>
                  </p>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Abas de Ano -->
  <ul class="nav nav-pills mb-3" id="yearTabs" role="tablist">
    <?php for ($year = date('Y'); $year >= 2020; $year--): ?>
    <li class="nav-item">
      <a class="nav-link year-tab <?= $year == $selectedYear ? 'active' : '' ?>" data-year="<?= $year ?>"
        href="javascript:void(0);" role="tab"><?= $year ?></a>
    </li>
    <?php endfor; ?>
  </ul>

  <!-- Abas de Mês -->
  <ul class="nav nav-tabs mb-3" id="monthTabs" role="tablist">
    <?php
    $months = [
      1 => 'Janeiro',
      2 => 'Fevereiro',
      3 => 'Março',
      4 => 'Abril',
      5 => 'Maio',
      6 => 'Junho',
      7 => 'Julho',
      8 => 'Agosto',
      9 => 'Setembro',
      10 => 'Outubro',
      11 => 'Novembro',
      12 => 'Dezembro'
    ];
    foreach ($months as $key => $month): ?>
    <li class="nav-item">
      <a class="nav-link <?= $key == $selectedMonth ? 'active' : '' ?>" data-month="<?= $key ?>"
        href="javascript:void(0);" role="tab"><?= $month ?></a>
    </li>
    <?php endforeach; ?>
  </ul>

  <!-- GridView para Listar Faturas -->
  <div id="faturasContent">
    <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
          'attribute' => 'id_bancos',
          'value' => 'banco.nome',
          'label' => 'Banco',
        ],
        'descricao',
        [
          'attribute' => 'data',
          'format' => ['date', 'php:d/m/Y'],
          'label' => 'Data',
          'contentOptions' => ['class' => 'text-center'],
        ],
        [
          'attribute' => 'valor',
          'format' => 'currency',
          'label' => 'Valor',
          'contentOptions' => ['class' => 'text-right text-success'],
        ],
        [
          'attribute' => 'category_id',
          'value' => 'category.desc_category',
          'label' => 'Categoria',
        ],
        [
          'class' => 'yii\grid\ActionColumn',
          'template' => '{view} {update} {delete}',
          'contentOptions' => ['class' => 'text-end'],
          'buttons' => [
            'view' => function ($url, $model) {
              return Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'btn btn-outline-info btn-sm', 'title' => 'Visualizar']);
            },
            'update' => function ($url, $model) {
              return Html::a('<i class="fas fa-pencil-alt"></i>', $url, ['class' => 'btn btn-outline-primary btn-sm', 'title' => 'Atualizar']);
            },
            'delete' => function ($url, $model) {
              return Html::a('<i class="fas fa-trash-alt"></i>', $url, [
                'class' => 'btn btn-outline-danger btn-sm',
                'title' => 'Excluir',
                'data' => [
                  'confirm' => 'Tem certeza que deseja excluir esta fatura?',
                  'method' => 'post',
                ],
              ]);
            },
          ],
        ],
      ],
      'options' => ['class' => 'table-responsive'],
      'tableOptions' => ['class' => 'table table-bordered table-hover table-striped text-center'],
    ]); ?>
  </div>
</div>

<script>
$(document).ready(function() {
  // Clique em abas de ano
  $('.year-tab').click(function() {
    var year = $(this).data('year');
    window.location.href = '?ano=' + year;
  });

  // Clique em abas de mês
  $('.nav-link[data-month]').click(function() {
    var month = $(this).data('month');
    var year = '<?= $selectedYear ?>';
    window.location.href = '?ano=' + year + '&mes=' + month;
  });
});
</script>