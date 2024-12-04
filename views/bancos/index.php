<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\Faturas;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\assets\BancosAsset;
use miloschuman\highcharts\Highcharts;
// Registra o AssetBundle (inclui o JavaScript)
BancosAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\models\BancosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $bancos app\models\Bancos[] */
/* @var $selectedYear string */
$this->title = 'Bancos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bancos-index container-fluid">
  <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
    <?php
    // Definindo ícones para diferentes tipos de mensagem
    $icon = '';
    switch ($key) {
      case 'success':
        $icon = 'fas fa-check-circle';
        break;
      case 'error':
        $icon = 'fas fa-exclamation-circle';
        break;
      case 'warning':
        $icon = 'fas fa-exclamation-triangle';
        break;
    }
    ?>
    <div class="alert alert-dismissible alert-<?= substr($key, strpos($key, '-') + 1) ?> fade-in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <i class="<?= $icon ?>"></i> <!-- Ícone adicionado -->
      <p><?= $message ?></p>
      <?php Yii::$app->session->removeFlash($key); ?>
      <!-- Removendo a mensagem da sessão após exibição -->
    </div>
  <?php endforeach; ?>
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex justify-content-end mb-3"></div>
    <h1 class="flex-grow-1 text-center"><?= Html::encode($this->title) ?></h1>
    <div class="btn-group ms-3" role="group">
      <?= Html::a('Adicionar Banco', ['create'], ['class' => 'btn btn-primary ripple']) ?>
      <?= Html::a('Listar Faturas', ['faturas/index'], ['class' => 'btn btn-outline-secondary ripple']) ?>
      <?= Html::button('Pesquisar Bancos', ['class' => 'btn btn-primary ripple', 'data-toggle' => 'modal', 'data-target' => '#searchModal']) ?>
    </div>
    <!-- Botão que aciona o modal -->
  </div>
  <!-- Renderização do modal de busca -->
  <?= $this->render('_search', ['searchModel' => $searchModel]); ?>
  <!-- Tabela de Bancos -->
  <div class="card mb-2">
    <div class="card-header bg-secondary text-white">
      <h3 class="mb-0">Bancos Cadastrados</h3>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th style="width: 50px;">#</th>
              <th style="width: 200px;">Nome do Banco</th>
              <th style="width: 300px;">Descrição</th>
              <th style="width: 90px;">Data Início</th>
              <th style="width: 90px;">Data Fechamento</th>
              <th style="width: 200px;">Ações</th>
              <th style="width: 170px;">Adicionar Fatura</th>
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
                <td>
                  <?= $banco->data_inicio_cartao ? Yii::$app->formatter->asDate($banco->data_inicio_cartao, 'php:d') : 'N/A' ?>
                </td>
                <td>
                  <?= $banco->data_fechamento_cartao ? Yii::$app->formatter->asDate($banco->data_fechamento_cartao, 'php:d') : 'N/A' ?>
                </td>
                <td>
                  <!-- Ações do banco -->
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
                  <!-- Adicionar Fatura -->
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
              </tr>
              <!-- Linhas de faturas associadas ao banco -->
              <tr id="faturas-<?= $banco->id_bancos ?>" class="fatura-row" style="display: none;">
                <td colspan="8">
                  <div class="card mt-2">
                    <div class="card-body">
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
                      <!-- Adicionar abas para os meses -->
                      <ul class="nav nav-tabs" id="tab-<?= $banco->id_bancos ?>" role="tablist">
                        <?php
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
                                    <th style="width: 230px;">Ações</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  // Formatar o mês e o dia para garantir que eles tenham 2 dígitos
                                  $currentMonth = str_pad($i + 1, 2, '0', STR_PAD_LEFT);  // Exemplo: '01' para Janeiro, '02' para Fevereiro, etc.
                                  // Extrair apenas o dia de "data_inicio_cartao" e "data_fechamento_cartao"
                                  $startDay = $banco->data_inicio_cartao ? str_pad(date('d', strtotime($banco->data_inicio_cartao)), 2, '0', STR_PAD_LEFT) : '01';
                                  $endDay = $banco->data_fechamento_cartao ? str_pad(date('d', strtotime($banco->data_fechamento_cartao)), 2, '0', STR_PAD_LEFT) : '28';
                                  // Definir a data de início com o ano e mês selecionado
                                  try {
                                    $startDate = new DateTime("{$selectedYear}-{$currentMonth}-{$startDay}");
                                    $startDate->modify('-1 month');
                                    // Caso o fechamento seja no próximo mês, ajustamos o mês de `$endDate`
                                    // O ajuste aqui vai garantir que a data de fechamento seja no mês de fechamento
                                    $nextMonth = ($currentMonth == '12') ? '01' : str_pad($i + 2, 2, '0', STR_PAD_LEFT); // Aumenta o mês para o próximo, ou janeiro se for dezembro
                                    $endDate = new DateTime("{$selectedYear}-{$nextMonth}-{$endDay}");
                                    $endDate->modify('-1 month');
                                  } catch (Exception $e) {
                                    // Em caso de erro, defina datas padrão
                                    $startDate = new DateTime("{$selectedYear}-{$currentMonth}-01");
                                    $endDate = new DateTime("{$selectedYear}-{$currentMonth}-28");
                                  }
                                  // Obtendo faturas para o mês atual e banco
                                  $faturasPorMes = Faturas::find()
                                    ->where(['id_bancos' => $banco->id_bancos])
                                    ->andWhere(['between', 'data', $startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                                    ->all();
                                  // Inicializar arrays para categorias e valores do gráfico
                                  $categorias = [];
                                  $valores = [];
                                  foreach ($faturasPorMes as $fatura) {
                                    $categoria = $fatura->category->desc_category; // Ajuste se necessário
                                    if (isset($categorias[$categoria])) {
                                      $categorias[$categoria] += $fatura->valor;
                                    } else {
                                      $categorias[$categoria] = $fatura->valor;
                                    }
                                  }
                                  // Verificar se há faturas para o mês
                                  if (empty($faturasPorMes)) {
                                    // Caso não haja faturas, você pode exibir uma mensagem ou deixar o gráfico vazio
                                    $graficoLabels = ['Sem dados'];
                                    $graficoValores = [1];
                                  } else {
                                    $graficoLabels = array_keys($categorias); // Categorias para o gráfico
                                    $graficoValores = array_values($categorias); // Valores para o gráfico
                                  }
                                  if (!empty($faturasPorMes)) {
                                    foreach ($faturasPorMes as $fatura): ?>
                                      <tr>
                                        <td data-descricao="<?= Html::encode($fatura->descricao) ?>">
                                          <?= Html::encode($fatura->descricao) ?></td>
                                        <td data-data="<?= Yii::$app->formatter->asDate($fatura->data, 'php:d/m/Y') ?>">
                                          <?= Yii::$app->formatter->asDate($fatura->data, 'php:d/m') ?></td>
                                        <td data-valor="<?= Yii::$app->formatter->asCurrency($fatura->valor, 'BRL') ?>">
                                          <?= Yii::$app->formatter->asCurrency($fatura->valor, 'BRL') ?>
                                        </td>
                                        <td data-parcelas="<?= Html::encode($fatura->parcelas) ?>">
                                          <?= Html::encode($fatura->parcelas) ?></td>
                                        <td data-categoria="<?= Html::encode($fatura->category->desc_category ?? 'N/A') ?>">
                                          <?= Html::encode($fatura->category->desc_category ?? 'N/A') ?></td>
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
                                          <!-- Botão de Copiar -->
                                          <?= Html::a('<span class="glyphicon glyphicon-copy"></span>', '#', [
                                            'class' => 'btn btn-warning btn-sm btn-copy-fatura',
                                            'title' => 'Copiar Fatura',
                                            'data-id' => $fatura->id_fatura, // ID da fatura para copiar
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
                                  <?= $selectedYear ?> <?= $month ?></h5>
                              </div>
                              <div class="card-body">
                                <!-- Resumo das Faturas -->
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
                                <?php

                                // Inicializar arrays para as categorias e os dados diários
                                $categorias = [];
                                $dadosPorDia = [];
                                $totalDespesas = 0;

                                // Verifica se faturas estão disponíveis
                                if (!empty($faturasPorMes)) {
                                  foreach ($faturasPorMes as $fatura) {
                                    // Atribuir categoria e valor
                                    $categoria = isset($fatura->category->desc_category) ? $fatura->category->desc_category : 'Categoria Desconhecida';
                                    $valor = (isset($fatura->valor) && is_numeric($fatura->valor)) ? $fatura->valor : 0;
                                    $dia = (int)date('d', strtotime($fatura->data));  // Extrair o dia da fatura como inteiro

                                    // Acumular os valores por dia e categoria
                                    if (!isset($dadosPorDia[$dia])) {
                                      $dadosPorDia[$dia] = [];
                                    }

                                    if (!isset($dadosPorDia[$dia][$categoria])) {
                                      $dadosPorDia[$dia][$categoria] = 0;
                                    }

                                    $dadosPorDia[$dia][$categoria] += $valor;  // Somar o valor da fatura para o dia e categoria

                                    // Acumulando o valor total
                                    $totalDespesas += $valor;

                                    // Adicionar categorias únicas ao array
                                    if (!in_array($categoria, $categorias)) {
                                      $categorias[] = $categoria;
                                    }
                                  }
                                }

                                // Definir os dados para o gráfico de pizza
                                $graficoData = [];
                                if (!empty($categorias)) {
                                  foreach ($categorias as $categoria) {
                                    $valorCategoria = 0;
                                    // Soma o valor total de cada categoria
                                    foreach ($dadosPorDia as $dia => $categoriasDia) {
                                      $valorCategoria += isset($categoriasDia[$categoria]) ? $categoriasDia[$categoria] : 0;
                                    }
                                    // Adiciona os dados para o gráfico de pizza
                                    $graficoData[] = [
                                      'name' => $categoria,
                                      'y' => (float)$valorCategoria, // Garantir que o valor seja um número float
                                      'sliced' => false,
                                      'selected' => false,
                                      'id' => $categoria, // Adiciona um identificador único para cada ponto
                                      'tooltip' => [
                                        'valueSuffix' => ' R$', // Sufixo de valor no tooltip
                                        'pointFormat' => '{point.name}: <b>R$ {point.y}</b> ({point.percentage:.1f}%)',
                                      ],
                                    ];
                                  }
                                }

                                // Definir os dados para o gráfico de área
                                $graficoDataArea = [];
                                $graficoLabels = range(1, date('t', strtotime("{$selectedYear}-{$currentMonth}-01"))); // Número real de dias no mês

                                foreach ($categorias as $categoria) {
                                  $graficoDataArea[$categoria] = [];
                                  foreach ($graficoLabels as $dia) {
                                    $valorDia = isset($dadosPorDia[$dia][$categoria]) ? $dadosPorDia[$dia][$categoria] : 0;
                                    $graficoDataArea[$categoria][] = $valorDia;
                                  }
                                }

                                $seriesArea = [];
                                $cores = [
                                  '#7cb5ec',
                                  '#434348',
                                  '#90ed7d',
                                  '#f7a35c',
                                  '#8085e9',
                                  '#f15c80',
                                  '#e4d354',
                                  '#2b908f',
                                  '#f45b5b',
                                  '#91e8e1',
                                ];
                                $indexCor = 0;

                                foreach ($graficoDataArea as $categoria => $dados) {
                                  $seriesArea[] = [
                                    'name' => $categoria,
                                    'data' => $dados,
                                    'color' => $cores[$indexCor % count($cores)],
                                    'lineWidth' => 2,
                                    'marker' => [
                                      'enabled' => false,
                                    ],
                                    'tooltip' => [
                                      'valueSuffix' => ' R$',
                                    ],
                                  ];
                                  $indexCor++;
                                }

                                // Início do container para os gráficos empilhados
                                echo '<div class="graph-container" style="display: flex; flex-direction: column; gap: 40px; width: 100%;">';

                                // Gráfico de Pizza
                                echo Highcharts::widget([
                                  'options' => [
                                    'title' => [
                                      'text' => Yii::t('app', 'Despesas por Categoria'),
                                      'align' => 'center',
                                    ],
                                    'credits' => ['enabled' => false],
                                    'chart' => [
                                      'type' => 'pie',
                                      'height' => 400,
                                      'events' => [
                                        'load' => new \yii\web\JsExpression("
                    function() {
                        var chart = this;
                        // Adiciona o rótulo central
                        chart.customLabel = chart.renderer.text(
                            'R$ " . number_format($totalDespesas, 2, ',', '.') . "',
                            chart.plotWidth / 2 - 2, // Ajuste a posição X conforme necessário
                            chart.plotHeight / 1.5
                        )
                        .attr({
                            align: 'center',
                            zIndex: 5
                        })
                        .css({
                            color: 'rgb(255, 255, 255)',
                            fontSize: '16px',
                            fontWeight: 'bold',
                            textAlign: 'center',
                            textShadow: '2px 2px 6px rgba(0, 0, 0, 0.7)', // Sombra do texto
                            textStroke: '2px rgba(0, 0, 0, 0.9)', // Borda em torno das letras
                            transition: 'all 0.3s ease', // Transição suave para hover
                        })
                        .add();

                        // Adicionando o efeito de hover
                        chart.customLabel.on('mouseover', function() {
                            chart.customLabel.css({
                                color: 'rgb(255, 223, 0)', // Cor dourada no hover
                                textShadow: '4px 4px 8px rgba(0, 0, 0, 0.9)', // Sombra mais intensa
                                textStroke: '2px rgba(0, 0, 0, 1)', // Aumentando a borda
                                cursor: 'pointer', // Muda o cursor para indicar interatividade
                            });
                        });

                        // Restaurar o estilo original quando o mouse sair
                        chart.customLabel.on('mouseout', function() {
                            chart.customLabel.css({
                                color: 'rgb(255, 255, 255)', // Cor original
                                textShadow: '2px 2px 6px rgba(0, 0, 0, 0.7)', // Sombra original
                                textStroke: '1px rgba(0, 0, 0, 0.9)', // Borda original
                                transform: 'scale(1)', // Restaura o tamanho original
                            });
                        });
                    }
                "),
                                      ],
                                    ],
                                    'series' => [
                                      [
                                        'name' => Yii::t('app', 'Valor'),
                                        'data' => $graficoData,
                                        'colorByPoint' => true,
                                        'dataLabels' => [
                                          'enabled' => true,
                                          'format' => '{point.name}: {point.percentage:.1f}%', // Exibe a porcentagem na fatia
                                        ],
                                        'point' => [
                                          'events' => [
                                            'legendItemClick' => new \yii\web\JsExpression("
                                          function() {
                                              var chart = this.series.chart;
                                              var total = " . json_encode($totalDespesas) . ";
                                              var remainingTotal = 0;
              
                                              // Toggle visibility
                                              if (this.visible) {
                                                  this.setVisible(false);
                                              } else {
                                                  this.setVisible(true);
                                              }
              
                                              // Recalcular o total sem a categoria
                                              chart.series[0].data.forEach(function(point) {
                                                  if (point.visible) {
                                                      remainingTotal += point.y;
                                                  }
                                              });
              
                                              // Atualizar o rótulo central
                                              chart.customLabel.attr({
                                                  text: 'R$ ' + remainingTotal.toFixed(2)
                                              });
              
                                              return false; // Prevenir comportamento padrão
                                          }
                                      "),
                                            'click' => new \yii\web\JsExpression("
                            function() {
    var chart = this.series.chart;
    var point = this;

    // Se não houver tempo de clique anterior, é um clique simples
    if (!point.clickTimeout) {
        // Primeiro clique - Marca a fatia como selecionada
        point.clickTimeout = setTimeout(function() {
            // Alterna entre selecionar e desmarcar
            if (point.selected) {
                point.slice(null, false); // Deselect (reduz a fatia)
                point.selected = false;
            } else {
                point.slice(null, true); // Select (expande a fatia)
                point.selected = true;
            }
            delete point.clickTimeout;
        }, 300);
    } else {
        // Se houver um tempo de clique anterior, é um duplo clique
        clearTimeout(point.clickTimeout);
        delete point.clickTimeout;

        // Duplo clique - Exclui ou reinclui a fatia
        if (point.excluded) {
            point.setVisible(true); // Reincluir a fatia
            point.excluded = false;
        } else {
            point.setVisible(false); // Excluir a fatia
            point.excluded = true;
        }

        // Recalcula o total após a exclusão
        var currentTotal = 0;
        chart.series[0].data.forEach(function(p) {
            if (p.visible) {
                currentTotal += p.y;
            }
        });

        // Atualiza o rótulo do total
        chart.customLabel.attr({
            text: 'R$ ' + Highcharts.numberFormat(currentTotal, 2, ',', '.')
        });

        totalDespesas = currentTotal; // Atualiza o total global
    }
}

                        "),
                                          ],
                                        ],
                                      ],
                                    ],
                                    'tooltip' => [
                                      'pointFormat' => '{series.name}: <b>R$ {point.y}</b> ({point.percentage:.1f}%)',
                                    ],
                                    'plotOptions' => [
                                      'pie' => [
                                        'allowPointSelect' => true,
                                        'cursor' => 'pointer',
                                        'showInLegend' => true,
                                        'dataLabels' => [
                                          'enabled' => true,
                                          'format' => '{point.name}: {point.percentage:.1f}%',
                                        ],
                                      ],
                                    ],
                                    'legend' => [
                                      'layout' => 'vertical',
                                      'align' => 'right',
                                      'verticalAlign' => 'middle',
                                      'itemStyle' => [
                                        'color' => '#333',
                                        'fontWeight' => 'normal',
                                      ],
                                    ],
                                  ],
                                ]);

                                // Gráfico de Áreas Empilhadas
                                echo Highcharts::widget([
                                  'options' => [
                                    'credits' => ['enabled' => false],
                                    'chart' => [
                                      'type' => 'area',
                                      'height' => 400,
                                      'zoomType' => 'x',
                                    ],
                                    'title' => [
                                      'text' => Yii::t('app', 'Despesas Diárias por Categoria'),
                                    ],
                                    'xAxis' => [
                                      'categories' => $graficoLabels,
                                      'title' => ['text' => 'Dia do Mês'],
                                      'labels' => [
                                        'rotation' => -45,
                                        'style' => [
                                          'fontSize' => '12px',
                                          'fontFamily' => 'Arial, sans-serif',
                                        ],
                                      ],
                                    ],
                                    'yAxis' => [
                                      'title' => ['text' => 'Valor (R$)'],
                                      'min' => 0,
                                      'labels' => [
                                        'formatter' => new \yii\web\JsExpression('function() { return "R$ " + this.value; }'),
                                      ],
                                    ],
                                    'tooltip' => [
                                      'shared' => true,
                                      'pointFormat' => '<span style="color:{series.color}">{series.name}</span>: <b>R$ {point.y:.2f}</b><br/>',
                                    ],
                                    'legend' => [
                                      'align' => 'center',
                                      'verticalAlign' => 'top',
                                      'floating' => false,
                                      'backgroundColor' => '#FFFFFF',
                                      'borderWidth' => 1,
                                      'borderColor' => '#CCC',
                                    ],
                                    'plotOptions' => [
                                      'area' => [
                                        'stacking' => 'normal',
                                        'marker' => [
                                          'enabled' => false,
                                        ],
                                        'dataLabels' => [
                                          'enabled' => false,
                                        ],
                                        'lineWidth' => 2,
                                      ],
                                    ],
                                    'series' => $seriesArea,
                                  ],
                                ]);

                                echo '</div>';

                                ?>


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
  <!-- Modal de Copiar Fatura -->
  <div class="modal fade" id="copyFaturaModal" tabindex="-1" role="dialog" aria-labelledby="copyFaturaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <!-- Modal grande para melhor espaçamento -->
      <div class="modal-content">
        <!-- Cabeçalho do Modal -->
        <div class="modal-header">
          <h5 class="modal-title" id="copyFaturaModalLabel">Copiar Fatura</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- Corpo do Modal -->
        <div class="modal-body">
          <form id="copyFaturaForm">
            <input type="hidden" id="faturaId" name="fatura_id">
            <div class="form-row">
              <div class="form-group">
                <label for="faturaDescricao">Descrição</label>
                <input type="text" class="form-control" id="faturaDescricao" name="descricao" readonly>
              </div>
              <div class="form-group">
                <label for="faturaData">Data</label>
                <input type="text" class="form-control" id="faturaData" name="data">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label for="faturaValor">Valor</label>
                <input type="text" class="form-control" id="faturaValor" name="valor">
              </div>
              <div class="form-group">
                <label for="faturaParcelas">Parcelas</label>
                <input type="text" class="form-control" id="faturaParcelas" name="parcelas">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label for="faturaCategoria">Categoria</label>
                <input type="text" class="form-control" id="faturaCategoria" name="categoria" readonly>
              </div>
              <div class="form-group">
                <label for="faturaBanco">Escolher Banco</label>
                <select class="form-control" id="faturaBanco" name="banco_id" required>
                  <option value="">Selecione um Banco</option>
                  <?php foreach ($bancos as $destBanco): ?>
                    <option value="<?= $destBanco->id_bancos ?>"><?= Html::encode($destBanco->nome) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <!-- Botão de Submissão -->
            <?= Html::submitButton('Copiar Fatura', ['class' => 'btn btn-success ripple']) ?>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Passa a URL para o JavaScript -->
  <script>
    var copyFaturaUrl = '<?= Url::to(['bancos/copy-fatura']) ?>';
  </script>
</div>