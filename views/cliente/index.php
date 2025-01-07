<?php

use app\assets\ClientesAsset;
use app\models\ProdutosClientes;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

// Registra o AssetBundle (inclui o JavaScript)
ClientesAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\ProdutosClientes */
/* @var $form yii\widgets\ActiveForm */
/* @var $clientes array */ // Certifique-se de passar a lista de clientes para a view

$this->title = Yii::t('app', 'Clientes');
$this->params['breadcrumbs'][] = $this->title;

// Inicialização de variáveis (se necessário)
$totalQuantidade = 0;
$totalValorCliente = 0;
$totalValorRevendedor = 0;
$lucro = $totalValorCliente - $totalValorRevendedor;
$parcelas = 1;

?>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="cliente-index bancos-index container-fluid">
        <!-- Título da Página -->
        <h1><?= Html::encode($this->title) ?></h1>

        <!-- Botões Separados do Título -->
        <div class="d-flex justify-content-end mb-3">
          <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Create'), ['/cliente/create'], [
            'class' => 'btn btn-primary mr-2',
          ]) ?>
          <?= Html::button('<i class="fa fa-upload"></i> ' . Yii::t('app', 'Upload PDF'), [
            'class' => 'btn btn-secondary mr-2',
            'data-toggle' => 'modal',
            'data-target' => '#UploadPdfModal',
          ]) ?>
          <?= Html::button('<i class="fa fa-search"></i> ' . Yii::t('app', 'Search'), [
            'class' => 'btn btn-info',
            'data-toggle' => 'modal',
            'data-target' => '#SearchModal',
          ]) ?>
        </div>



        <!-- Alertas de Flash Messages -->
        <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
        <div class="alert alert-dismissible alert-<?= substr($key, strpos($key, '-') + 1) ?> fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <p><?= $message ?></p>
        </div>
        <?php endforeach ?>

        <!-- Modal para Pesquisa/Filtro -->
        <div class="modal fade" id="SearchModal" tabindex="-1" role="dialog" aria-labelledby="SearchModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="SearchModalLabel">Filtros de Pesquisa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <?= $this->render('_search', [
                  'searchModel' => $searchModel,
                  'dataProvider' => $dataProvider,
                ]); ?>
              </div>
              <div class="modal-footer">
                <?= Html::submitButton('Filtrar', ['class' => 'btn btn-primary', 'form' => 'search-form']) ?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal para Upload PDF -->
        <div class="modal fade" id="UploadPdfModal" tabindex="-1" role="dialog" aria-labelledby="UploadPdfModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="UploadPdfModalLabel">Upload de PDF</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <?php $form = ActiveForm::begin(['id' => 'UploadPdfForm', 'action' => ['pdf-upload/upload'], 'options' => ['enctype' => 'multipart/form-data']]); ?>

                <?= $form->field($model, 'clienteId')->hiddenInput(['id' => 'upload-clienteId'])->label(false) ?>

                <div class="form-group">
                  <?= Html::label('Selecionar PDF', 'pdfFile', ['class' => 'font-weight-bold']) ?>
                  <?= Html::fileInput('pdfFile', null, ['class' => 'form-control', 'id' => 'pdfFile', 'accept' => 'application/pdf', 'required' => true]) ?>
                </div>

                <div class="d-flex justify-content-center mt-4">
                  <?= Html::submitButton('<i class="fa fa-floppy-o"></i> Salvar', ['class' => 'btn btn-primary mx-2']) ?>
                  <button type="button" class="btn btn-secondary mx-2" data-dismiss="modal">Fechar</button>
                </div>

                <?php ActiveForm::end(); ?>
              </div>
            </div>
          </div>
        </div>

        <!-- Tabela de Clientes -->
        <div class="table-responsive table-container">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Nome do Cliente</th>
                <th>Data de Registro</th>
                <th>Última Edição</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($dataProvider->models as $cliente): ?>
              <!-- Linha Principal do Cliente -->
              <tr class="clickable-row" data-id="<?= $cliente->id ?>" data-nome="<?= Html::encode($cliente->nome) ?>">
                <td><?= Html::encode($cliente->nome) ?></td>
                <td><?= Yii::$app->formatter->asDate($cliente->data_registro, 'dd/MM') ?></td>
                <td><?= Yii::$app->formatter->asDate($cliente->edit_datetime, 'dd/MM') ?></td>
                <td>
                  <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['cliente/update', 'id' => $cliente->id], [
                      'class' => 'btn btn-warning btn-action',
                      'title' => Yii::t('app', 'Edit'),
                      'data-toggle' => 'tooltip',
                      'data-placement' => 'top',
                    ]) ?>

                  <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['cliente/delete', 'id' => $cliente->id], [
                      'class' => 'btn btn-danger btn-action',
                      'data-confirm' => Yii::t('app', 'Tem certeza que quer Deletar esse Cliente?'),
                      'data-method' => 'post',
                      'title' => Yii::t('app', 'Delete'),
                      'data-toggle' => 'tooltip',
                      'data-placement' => 'top',
                    ]) ?>

                  <?= Html::button('<i class="fa fa-plus"></i>', [
                      'class' => 'btn btn-success btn-action',
                      'title' => Yii::t('app', 'Add Product'),
                      'data-toggle' => 'modal',
                      'data-target' => '#CreateProductModal',
                      'data-cliente-id' => Html::encode($cliente->id),
                      'data-cliente-nome' => Html::encode($cliente->nome),
                    ]) ?>

                  <?= Html::button('<i class="fa fa-upload"></i>', [
                      'class' => 'btn btn-secondary btn-action',
                      'title' => Yii::t('app', 'Upload PDF'),
                      'data-toggle' => 'modal',
                      'data-target' => '#UploadPdfModal',
                      'data-cliente-id' => Html::encode($cliente->id),
                      'data-cliente-nome' => Html::encode($cliente->nome),
                    ]) ?>
                </td>
              </tr>

              <!-- Linha Detalhada do Cliente (Produtos e Informações Adicionais) -->
              <tr id="product-row-<?= $cliente->id ?>" style="display: none;">
                <td colspan="4">
                  <div class="row">
                    <!-- Tabela de Produtos -->
                    <div class="col-md-12">
                      <table class="table table-bordered table-striped table-hover">
                        <thead>
                          <tr>
                            <th>Data Do Pedido</th>
                            <th>Data de Entrega</th>
                            <th>Nome do Produto</th>
                            <th>Quantidade</th>
                            <th>Valor Cliente</th>
                            <th>Valor Revendedor</th>
                            <th>Ações</th>
                          </tr>
                        </thead>
                        <tbody id="product-table-body-<?= $cliente->id ?>">
                          <?php if (!empty($cliente->produtosClientes)): ?>
                          <?php foreach ($cliente->produtosClientes as $produto): ?>
                          <tr>
                            <td><?= Yii::$app->formatter->asDate($produto->data, 'dd/MM') ?></td>
                            <td><?= Yii::$app->formatter->asDate($produto->data_entrega, 'dd/MM') ?></td>
                            <td><?= Html::encode($produto->produto) ?></td>
                            <td><?= Html::encode($produto->quantidade) ?></td>
                            <td><?= Yii::$app->formatter->asCurrency($produto->valor_cliente) ?></td>
                            <td><?= Yii::$app->formatter->asCurrency($produto->valor_pagamento) ?></td>
                            <td>
                              <!-- Botão de Edição -->
                              <?= Html::button('<span class="glyphicon glyphicon-pencil"></span>', [
                                      'class' => 'btn btn-warning btn-sm mr-1 edit-product-btn',
                                      'data-toggle' => 'modal',
                                      'data-target' => '#UpdateProductModal',
                                      'data-client-id' => $cliente->id,
                                      'data-cliente-nome' => $cliente->nome,
                                      'data-product-id' => Html::encode($produto->id),
                                      'data-date' => Yii::$app->formatter->asDate($produto->data, 'yyyy-MM-dd'),
                                      'data-delivery-date' => Yii::$app->formatter->asDate($produto->data_entrega, 'yyyy-MM-dd'),
                                      'data-product-name' => Html::encode($produto->produto),
                                      'data-quantity' => Html::encode($produto->quantidade),
                                      'data-client-value' => Html::encode($produto->valor_cliente),
                                      'data-payment-value' => Html::encode($produto->valor_pagamento),
                                    ]) ?>

                              <!-- Botão de Deleção -->
                              <?= Html::a(
                                      '<span class="glyphicon glyphicon-trash"></span>',
                                      ['cliente/deleteproduct', 'id' => $produto->id],
                                      [
                                        'class' => 'btn btn-danger btn-sm mr-1',
                                        'data-confirm' => Yii::t('app', 'Tem certeza que quer Deletar esse Produto?'),
                                        'data-method' => 'post',
                                        'title' => Yii::t('app', 'Delete Product'),
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'top',
                                      ]
                                    ) ?>

                              <!-- Botão de Copiar Produto -->
                              <?= Html::button('<span class="glyphicon glyphicon-copy"></span>', [
                                      'class' => 'btn btn-info btn-sm copiar-produto-btn',
                                      'title' => Yii::t('app', 'Copiar Produto'),
                                      'data-toggle' => 'modal',
                                      'data-target' => '#CopiarProdutoModal',
                                      'data-product-id' => Html::encode($produto->id),
                                      'data-cliente-id' => Html::encode($cliente->id),
                                      'data-produto-name' => Html::encode($produto->produto),
                                      'data-quantidade' => Html::encode($produto->quantidade),
                                      'data-valor-cliente' => Html::encode($produto->valor_cliente),
                                      'data-valor-pagamento' => Html::encode($produto->valor_pagamento),
                                      'data-data-pedido' => Yii::$app->formatter->asDate($produto->data, 'yyyy-MM-dd'),
                                      'data-data-entrega' => Yii::$app->formatter->asDate($produto->data_entrega, 'yyyy-MM-dd'),
                                    ]) ?>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                          <?php else: ?>
                          <tr>
                            <td colspan="7" class="text-center">Nenhum produto adicionado ainda.</td>
                          </tr>
                          <?php endif; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <!-- Formulário de Informações Adicionais do Cliente -->
                  <form id="cliente-form-<?= $cliente->id ?>" method="POST"
                    action="<?= Url::to(['cliente/update', 'id' => $cliente->id]) ?>">
                    <div class="additional-info card mb-4" id="additional-info-<?= $cliente->id ?>">
                      <div class="card-header">
                        <h5 class="card-title">Informações do Cliente</h5>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <!-- Informações de Quantidade e Valores -->
                          <div class="col-md-6">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>Descrição</th>
                                  <th>Valor</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                  $totalQuantidade = 0;
                                  $totalValorCliente = 0;
                                  $totalValorRevendedor = 0;

                                  foreach ($cliente->produtosClientes as $produto) {
                                    $totalQuantidade += $produto->quantidade;
                                    $totalValorCliente += $produto->valor_cliente * $produto->quantidade;
                                    $totalValorRevendedor += $produto->valor_pagamento * $produto->quantidade;
                                  }
                                  $lucro = $totalValorCliente - $totalValorRevendedor;
                                  ?>
                                <tr>
                                  <td><strong>Quantidade Total:</strong></td>
                                  <td class="text-center text-primary"><?= $totalQuantidade ?></td>
                                </tr>
                                <tr>
                                  <td><strong>Valor Total Cliente:</strong></td>
                                  <td class="text-center text-success">
                                    <?= Yii::$app->formatter->asCurrency($totalValorCliente) ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td><strong>Valor Total Cliente Dividido:</strong></td>
                                  <td class="text-center text-primary">
                                    <?php if (isset($totalValorCliente, $cliente->parcelas) && is_numeric($totalValorCliente) && is_numeric($cliente->parcelas) && $cliente->parcelas > 0): ?>
                                    <?= Yii::$app->formatter->asCurrency($totalValorCliente / $cliente->parcelas) ?>
                                    <?php else: ?>
                                    <span>N/A</span>
                                    <?php endif; ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td><strong>Valor Restante Cliente:</strong></td>
                                  <td class="text-center text-primary">
                                    <?php
                                      $descricaoValue = $cliente->descricao;
                                      if (isset($totalValorCliente) && is_numeric($totalValorCliente)):
                                        try {
                                          $valorDescricao = eval("return $descricaoValue;");
                                        } catch (ParseError $e) {
                                          $valorDescricao = 0;
                                        }
                                      ?>
                                    <?php if (is_numeric($valorDescricao) && $valorDescricao > 0): ?>
                                    <?= Yii::$app->formatter->asCurrency($totalValorCliente - $valorDescricao) ?>
                                    <?php else: ?>
                                    <span>N/A</span>
                                    <?php endif; ?>
                                    <?php else: ?>
                                    <span>N/A</span>
                                    <?php endif; ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td><strong>Lucro:</strong></td>
                                  <td class="text-center text-success"><?= Yii::$app->formatter->asCurrency($lucro) ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td><strong>Lucro Dividido:</strong></td>
                                  <td class="text-center text-success">
                                    <?php if (is_numeric($lucro) && is_numeric($cliente->parcelas) && $cliente->parcelas > 0): ?>
                                    <?= Yii::$app->formatter->asCurrency($lucro / $cliente->parcelas) ?>
                                    <?php else: ?>
                                    <span>N/A</span>
                                    <?php endif; ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td><strong>Valor Total Revendedor:</strong></td>
                                  <td class="text-center text-danger">
                                    <?= Yii::$app->formatter->asCurrency($totalValorRevendedor) ?>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <!-- Parcelas, Forma de Pagamento e Descrições -->
                          <div class="col-md-6">
                            <!-- Parcelas e Forma de Pagamento na Mesma Linha -->
                            <div class="form-group">
                              <div class="row">
                                <div class="col-md-6 mb-3">
                                  <label for="parcelas-<?= $cliente->id ?>">Parcelado em:</label>
                                  <input type="number" class="form-control" id="parcelas-<?= $cliente->id ?>"
                                    name="parcelas" value="<?= Html::encode($cliente->parcelas) ?>" min="1" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                  <label for="forma_pagamento-<?= $cliente->id ?>">Forma de Pagamento:</label>
                                  <?php
                                    $paymentMethods = ['Dinheiro', 'Cartão', 'Transferência']; // Métodos de pagamento
                                    $selectedPayment = !empty($cliente->category) ? $cliente->category->desc_category : '';
                                    ?>
                                  <?= Html::dropDownList('forma_pagamento', $selectedPayment, $paymentMethods, [
                                      'class' => 'form-control',
                                      'prompt' => 'Selecione',
                                      'id' => 'forma_pagamento-' . $cliente->id,
                                      'required' => true,
                                    ]) ?>
                                </div>
                              </div>
                            </div>

                            <!-- Descrição, Checkbox e Datas Editáveis -->
                            <div class="form-group">
                              <label>Descrição, Pagamento e Datas:</label>
                              <div class="row">
                                <?php
                                  $parcelasCount = $cliente->parcelas ?? 1;  // Número de parcelas (default 1)
                                  $valorParcela = Yii::$app->formatter->asCurrency($totalValorCliente / $parcelasCount);  // Valor de cada parcela
                                  $descricaoValor = $totalValorCliente / $parcelasCount; // Valor de descrição dividido pela quantidade de parcelas
                                  $primeiraData = Yii::$app->formatter->asDate($cliente->data_registro, 'Y-m-d');  // Data de registro do cliente
                                  ?>
                                <?php for ($i = 1; $i <= $parcelasCount; $i++): ?>
                                <div class="col-md-4 mb-3">
                                  <label for="descricao-<?= $cliente->id ?>-<?= $i ?>">Descrição <?= $i ?>:</label>
                                  <input type="text" class="form-control" id="descricao-<?= $cliente->id ?>-<?= $i ?>"
                                    name="descricao-<?= $cliente->id ?>[]"
                                    value="<?= number_format($descricaoValor, 2, ',', '.') ?>" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                  <label for="data-<?= $cliente->id ?>-<?= $i ?>">Data <?= $i ?>:</label>
                                  <input type="date" class="form-control" id="data-<?= $cliente->id ?>-<?= $i ?>"
                                    name="data-<?= $cliente->id ?>[]" value="<?= $primeiraData ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                  <label for="pago-<?= $cliente->id ?>-<?= $i ?>">Pago:</label>
                                  <input type="checkbox" class="form-check-input"
                                    id="pago-<?= $cliente->id ?>-<?= $i ?>" name="pago-<?= $cliente->id ?>[]">
                                </div>
                                <?php endfor; ?>
                              </div>
                            </div>
                          </div>

                          <!-- Botões Salvar e Limpar dentro do Card -->
                          <div class="row mt-3">
                            <div class="col-md-12">
                              <?= Html::button('<i class="fa fa-save"></i> Salvar', [
                                  'class' => 'btn btn-primary salvar-cliente-btn mr-2',
                                  'data-cliente-id' => $cliente->id,
                                  'title' => 'Salvar',
                                  'data-toggle' => 'tooltip',
                                  'data-placement' => 'top',
                                ]) ?>
                              <?= Html::button('<i class="fa fa-eraser"></i> Limpar', [
                                  'class' => 'btn btn-secondary limpar-cliente-btn',
                                  'data-cliente-id' => $cliente->id,
                                  'title' => 'Limpar',
                                  'data-toggle' => 'tooltip',
                                  'data-placement' => 'top',
                                ]) ?>
                            </div>
                          </div>

                        </div>

                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                          const primeiraData = document.querySelector('[id^="data-"][id$="-1"]');
                          if (primeiraData) {
                            primeiraData.addEventListener('change', function() {
                              const baseDate = new Date(this.value);
                              const inputs = document.querySelectorAll('[id^="data-"]');
                              inputs.forEach((input, index) => {
                                if (index > 0) {
                                  const newDate = new Date(baseDate);
                                  newDate.setMonth(newDate.getMonth() + index);
                                  input.value = newDate.toISOString().split('T')[0];
                                }
                              });
                            });
                          }
                        });
                        </script>
                      </div>
                    </div>
                  </form>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <!-- Placeholder para Detalhes de Produtos (se necessário) -->
        <div id="product-details" style="margin-top: 20px;"></div>

      </div>
    </div>
  </div>
</div>

<!-- Modal para Adicionar Produtos -->
<div class="modal fade" id="CreateProductModal" tabindex="-1" role="dialog" aria-labelledby="CreateProductModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="CreateProductModalLabel">Adicionar Produto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="produtos-clientes-form">
          <?php $form = ActiveForm::begin(['id' => 'CreateProductForm', 'action' => ['cliente/create-product']]); ?>

          <?= $form->field($model, 'clienteId')->hiddenInput(['id' => 'clienteId'])->label(false) ?>

          <div class="form-group">
            <?= Html::label('User ID', 'userId', ['class' => 'font-weight-bold']) ?>
            <?= Html::textInput('userId', Yii::$app->user->id, ['id' => 'userId', 'class' => 'form-control text-center', 'readonly' => true]) ?>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6 mb-3">
              <?= $form->field($model, 'data')->textInput(['id' => 'date', 'type' => 'date', 'class' => 'form-control text-center'])->label('Data do Pedido', ['class' => 'font-weight-bold']) ?>
            </div>
            <div class="form-group col-md-6 mb-3">
              <?= $form->field($model, 'data_entrega')->textInput(['id' => 'delivery-date', 'type' => 'date', 'class' => 'form-control text-center'])->label('Data de Entrega', ['class' => 'font-weight-bold']) ?>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6 mb-3">
              <?= $form->field($model, 'produto')->textInput(['id' => 'product-name', 'maxlength' => true, 'class' => 'form-control text-center'])->label('Nome do Produto', ['class' => 'font-weight-bold']) ?>
            </div>
            <div class="form-group col-md-6 mb-3">
              <?= $form->field($model, 'quantidade')->textInput(['id' => 'quantity', 'type' => 'number', 'min' => 0, 'class' => 'form-control text-center'])->label('Quantidade', ['class' => 'font-weight-bold']) ?>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6 mb-3">
              <?= $form->field($model, 'valor_cliente')->textInput(['id' => 'client-value', 'type' => 'number', 'step' => '0.01', 'min' => 0, 'class' => 'form-control text-center'])->label('Valor Cliente', ['class' => 'font-weight-bold']) ?>
            </div>
            <div class="form-group col-md-6 mb-3">
              <?= $form->field($model, 'valor_pagamento')->textInput(['id' => 'payment-value', 'type' => 'number', 'step' => '0.01', 'min' => 0, 'class' => 'form-control text-center'])->label('Valor Revendedor', ['class' => 'font-weight-bold']) ?>
            </div>
          </div>

          <div class="d-flex justify-content-center mt-4">
            <?= Html::submitButton('<i class="fa fa-floppy-o"></i> Salvar', ['class' => 'btn btn-primary mx-2', 'id' => 'saveProductButton']) ?>
            <button type="button" class="btn btn-secondary mx-2" data-dismiss="modal">Fechar</button>
          </div>

          <?php ActiveForm::end(); ?>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <!-- Footer para mensagens adicionais, se necessário -->
      </div>
    </div>
  </div>
</div>

<!-- Modal para Atualização de Produtos -->
<div class="modal fade" id="UpdateProductModal" tabindex="-1" role="dialog" aria-labelledby="UpdateProductModalLabel">
  <div class="modal-dialog" role="document" style="max-width: 700px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="UpdateProductModalLabel">Atualizar Produto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php $form = ActiveForm::begin([
          'id' => 'UpdateProductForm',
          'action' => ['cliente/update-product'],
          'method' => 'post',
        ]); ?>

        <?= Html::hiddenInput('product_id', null, ['id' => 'product-id']) ?>

        <div class="form-row">
          <div class="form-group col-md-6">
            <?= $form->field($model, 'clienteId')->hiddenInput(['id' => 'clienteId'])->label(false) ?>
            <?= $form->field($model, 'clienteId')->textInput([
              'id' => 'clienteIdDisplay',
              'type' => 'text',
              'class' => 'form-control text-center',
              'readonly' => true,
              'placeholder' => 'Cliente',
            ])->label('Cliente', ['class' => 'font-weight-bold']) ?>
          </div>
        </div>

        <div class="form-group">
          <?= Html::label('User ID', 'userId', ['class' => 'font-weight-bold']) ?>
          <?= Html::textInput('userId', Yii::$app->user->id, [
            'id' => 'userId',
            'class' => 'form-control text-center',
            'readonly' => true,
          ]) ?>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <?= $form->field($model, 'data')->textInput([
              'id' => 'date',
              'type' => 'date',
              'class' => 'form-control text-center',
            ])->label('Data do Pedido', ['class' => 'font-weight-bold']) ?>
          </div>
          <div class="form-group col-md-6">
            <?= $form->field($model, 'data_entrega')->textInput([
              'id' => 'delivery-date',
              'type' => 'date',
              'class' => 'form-control text-center',
            ])->label('Data de Entrega', ['class' => 'font-weight-bold']) ?>
          </div>
        </div>

        <div class="form-group">
          <?= $form->field($model, 'produto')->textInput([
            'id' => 'product-name',
            'maxlength' => true,
            'class' => 'form-control text-center',
          ])->label('Nome do Produto', ['class' => 'font-weight-bold']) ?>
        </div>

        <div class="form-group">
          <?= $form->field($model, 'quantidade')->textInput([
            'id' => 'quantity',
            'type' => 'number',
            'min' => 0,
            'class' => 'form-control text-center',
          ])->label('Quantidade', ['class' => 'font-weight-bold']) ?>
        </div>

        <div class="form-group">
          <?= $form->field($model, 'valor_cliente')->textInput([
            'id' => 'client-value',
            'type' => 'number',
            'step' => '0.01',
            'min' => 0,
            'class' => 'form-control text-center',
          ])->label('Valor Cliente', ['class' => 'font-weight-bold']) ?>
        </div>

        <div class="form-group">
          <?= $form->field($model, 'valor_pagamento')->textInput([
            'id' => 'payment-value',
            'type' => 'number',
            'step' => '0.01',
            'min' => 0,
            'class' => 'form-control text-center',
          ])->label('Valor Revendedor', ['class' => 'font-weight-bold']) ?>
        </div>

        <div class="d-flex justify-content-center">
          <?= Html::submitButton('<i class="fa fa-floppy-o"></i> Salvar', [
            'class' => 'btn btn-primary mx-2',
            'id' => 'saveProductButton',
          ]) ?>
          <button type="button" class="btn btn-secondary mx-2" data-dismiss="modal">Fechar</button>
        </div>

        <?php ActiveForm::end(); ?>
      </div>
      <div class="modal-footer">
        <!-- Footer pode ser usado para mensagens adicionais, se necessário -->
      </div>
    </div>
  </div>
</div>

<!-- Modal para Copiar Produto -->
<div class="modal fade" id="CopiarProdutoModal" tabindex="-1" role="dialog" aria-labelledby="CopiarProdutoModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="CopiarProdutoModalLabel">Copiar Produto para Outro Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="copiar-produto-form">
          <?= Html::hiddenInput('product_id', '', ['id' => 'copiar-product-id']) ?>

          <div class="form-group">
            <label for="target_cliente_id">Selecione o Cliente:</label>
            <?= Html::dropDownList('target_cliente_id', null, ArrayHelper::map($clientes, 'id', 'nome'), [
              'class' => 'form-control',
              'prompt' => 'Selecione',
              'id' => 'target_cliente_id',
              'required' => true,
            ]) ?>
          </div>

          <div class="form-group">
            <label for="copy_quantity">Quantidade:</label>
            <?= Html::input('number', 'copy_quantity', 1, ['class' => 'form-control', 'id' => 'copy_quantity', 'min' => 1, 'required' => true]) ?>
          </div>

          <div class="form-group">
            <label for="copy_data_pedido">Data do Pedido:</label>
            <?= Html::input('date', 'copy_data_pedido', date('Y-m-d'), ['class' => 'form-control', 'id' => 'copy_data_pedido', 'required' => true]) ?>
          </div>

          <div class="form-group">
            <label for="copy_data_entrega">Data de Entrega:</label>
            <?= Html::input('date', 'copy_data_entrega', date('Y-m-d'), ['class' => 'form-control', 'id' => 'copy_data_entrega', 'required' => true]) ?>
          </div>

          <div class="form-group">
            <label for="copy_produto_nome">Nome do Produto:</label>
            <?= Html::textInput('copy_produto_nome', '', ['class' => 'form-control', 'id' => 'copy_produto_nome', 'required' => true]) ?>
          </div>

          <div class="form-group">
            <label for="copy_valor_cliente">Valor Cliente:</label>
            <?= Html::input('number', 'copy_valor_cliente', 0, ['class' => 'form-control', 'id' => 'copy_valor_cliente', 'step' => '0.01', 'min' => 0, 'required' => true]) ?>
          </div>

          <div class="form-group">
            <label for="copy_valor_revendedor">Valor Revendedor:</label>
            <?= Html::input('number', 'copy_valor_revendedor', 0, ['class' => 'form-control', 'id' => 'copy_valor_revendedor', 'step' => '0.01', 'min' => 0, 'required' => true]) ?>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <?= Html::button('Copiar', ['class' => 'btn btn-info', 'id' => 'copiar-produto-submit']) ?>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>


<!-- JavaScript -->
<script>
$(document).ready(function() {
  // Inicializar tooltips
  $('[data-toggle="tooltip"]').tooltip();

  // Função para preencher o modal de atualização de produto
  $(document).on('click', '.edit-product-btn', function() {
    const button = $(this);
    const productId = button.data('product-id');
    const clientId = button.data('client-id');
    const clienteNome = button.data('cliente-nome');
    const date = button.data('date');
    const deliveryDate = button.data('delivery-date');
    const productName = button.data('product-name');
    const quantity = button.data('quantity');
    const clientValue = button.data('client-value');
    const paymentValue = button.data('payment-value');

    $('#UpdateProductModal #product-id').val(productId);
    $('#UpdateProductModal #clienteId').val(clientId);
    $('#UpdateProductModal #clienteIdDisplay').val(clienteNome);

    $('#UpdateProductModal #product-name').val(productName);
    $('#UpdateProductModal #quantity').val(quantity);
    $('#UpdateProductModal #client-value').val(clientValue);
    $('#UpdateProductModal #payment-value').val(paymentValue);
    $('#UpdateProductModal #date').val(date);
    $('#UpdateProductModal #delivery-date').val(deliveryDate);
  });

  // Mostrar/ocultar a linha de produtos ao clicar na linha do cliente
  $('.clickable-row').click(function() {
    const clientId = $(this).data('id');
    $('#product-row-' + clientId).toggle();
    // Adicionar classe 'selected' para destacar o cliente
    $('.additional-info.card').removeClass('selected');
    $('#additional-info-' + clientId).addClass('selected');
  });

  // Salvar alterações do cliente via AJAX
  $('.salvar-cliente-btn').click(function() {
    var clienteId = $(this).data('cliente-id');
    var formData = $('#cliente-form-' + clienteId).serialize();

    $.ajax({
      url: '<?= Url::to(['cliente/update', 'id' => '']) ?>' + clienteId,
      type: 'POST',
      data: formData,
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          alert('Cliente salvo com sucesso!');
          location.reload();
        } else {
          alert('Erro ao salvar o cliente: ' + response.message);
        }
      },
      error: function() {
        alert('Erro na requisição.');
      }
    });
  });

  // Limpar formulário do cliente
  $('.limpar-cliente-btn').click(function() {
    var clienteId = $(this).data('cliente-id');
    $('#cliente-form-' + clienteId)[0].reset();
    // Remover seleção
    $('#additional-info-' + clienteId).removeClass('selected');
  });

  // Evento para quando o modal de criação de produto é exibido
  $('#CreateProductModal').on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget);
    const clientId = button.data('cliente-id');
    const clienteNome = button.data('cliente-nome');
    $('#CreateProductModal #clienteId').val(clientId);
    // Opcional: exibir nome do cliente no modal
    // $('#CreateProductModal #clienteNomeDisplay').text(clienteNome);
  });

  // Evento para quando o modal de upload de PDF é exibido
  $('#UploadPdfModal').on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget);
    const clientId = button.data('cliente-id');
    const clienteNome = button.data('cliente-nome');
    $('#UploadPdfModal #upload-clienteId').val(clientId);
    // Opcional: exibir nome do cliente no modal
    // $('#UploadPdfModal #clienteNomeDisplay').text(clienteNome);
  });

  // Envio do formulário de criação de produto via AJAX
  $('#CreateProductForm').on('beforeSubmit', function(e) {
    e.preventDefault();
    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          $('#CreateProductModal').modal('hide');
          alert(response.message);
          setTimeout(function() {
            location.reload();
          }, 1000);
        } else {
          alert('Erro ao salvar o produto: ' + JSON.stringify(response.errors));
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Erro ao salvar o produto. Detalhes: ' + errorThrown);
      }
    });
    return false;
  });

  // Envio do formulário de upload de PDF via AJAX
  $('#UploadPdfForm').on('beforeSubmit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          $('#UploadPdfModal').modal('hide');
          alert(response.message);
          setTimeout(function() {
            location.reload();
          }, 1000);
        } else {
          alert('Erro ao fazer upload do PDF: ' + response.message);
        }
      },
      error: function() {
        alert('Erro na requisição.');
      }
    });
    return false;
  });

  // Preencher o modal de copiar produto
  $(document).on('click', '.copiar-produto-btn', function() {
    var productId = $(this).data('product-id');
    var produtoNome = $(this).data('produto-name');
    var quantidade = $(this).data('quantidade');
    var valorCliente = $(this).data('valor-cliente');
    var valorPagamento = $(this).data('valor-pagamento');
    var dataPedido = $(this).data('data-pedido');
    var dataEntrega = $(this).data('data-entrega');

    $('#copiar-produto-form')[0].reset();
    $('#copiar-produto-form #copiar-product-id').val(productId);
    $('#copiar-produto-form #copy_produto_nome').val(produtoNome);
    $('#copiar-produto-form #copy_quantity').val(quantidade);
    $('#copiar-produto-form #copy_valor_cliente').val(valorCliente);
    $('#copiar-produto-form #copy_valor_revendedor').val(valorPagamento);
    $('#copiar-produto-form #copy_data_pedido').val(dataPedido);
    $('#copiar-produto-form #copy_data_entrega').val(dataEntrega);
  });

  // Enviar o formulário de copiar produto via AJAX
  $('#copiar-produto-submit').click(function() {
    var formData = $('#copiar-produto-form').serialize();

    $.ajax({
      url: '<?= Url::to(['cliente/copy-product']) ?>',
      type: 'POST',
      data: formData,
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          $('#CopiarProdutoModal').modal('hide');
          alert('Produto copiado com sucesso!');
          setTimeout(function() {
            location.reload();
          }, 1000);
        } else {
          alert('Erro ao copiar o produto: ' + response.message);
        }
      },
      error: function() {
        alert('Erro na requisição.');
      }
    });
  });
});
</script>