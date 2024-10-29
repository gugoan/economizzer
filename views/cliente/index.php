<?php

use app\models\ProdutosClientes;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\ProdutosClientes */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Entries');
$this->params['breadcrumbs'][] = $this->title;
$totalQuantidade = 0;
$totalValorCliente = 0;
$totalValorRevendedor = 0;
$lucro = $totalValorCliente - $totalValorRevendedor;
$parcelas = 1;


?>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-20">
      <div class="cliente-index">
        <div class="col-lg-3">
          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingOne">
                <strong><?php echo Yii::t('app', 'Filters'); ?>
                  <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFilter"
                    aria-expanded="true" aria-controls="collapseFilter">
                    <span class="glyphicon glyphicon-resize-small pull-right" aria-hidden="true"></span>
                  </a>
                </strong>
              </div>
              <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                  <?php echo $this->render('_search', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider, // Adicionado para resolver o erro
                  ]); ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <h2>
          <span><?= Html::encode($this->title) ?></span>
          <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Create'), ['/cliente/create'], [
            'class' => 'btn btn-primary grid-button pull-right',
            'style' => 'margin-right: 10px;',
          ]) ?>
          <?= Html::a('<i class="fa fa-upload"></i> ' . Yii::t('app', 'Upload PDF'), ['pdf-upload/upload'], [
            'class' => 'btn btn-secondary pull-right',
            'style' => 'margin-right: 10px;',
          ]) ?>
        </h2>
        <hr />
        <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
        <div class="alert alert-dismissible alert-<?= substr($key, strpos($key, '-') + 1) ?>" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <p><?= $message ?></p>
        </div>
        <?php endforeach ?>

        <div class="table-responsive table-container">
          <table class="table" style="width: 100%; text-align: center;">
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
              <tr class="clickable-row product-row " data-id="<?= $cliente->id ?>"
                data-nome="<?= Html::encode($cliente->nome) ?>">
                <td><?= Html::encode($cliente->nome) ?></td>
                <td><?= Html::encode($cliente->data_registro) ?></td>
                <td><?= Html::encode($cliente->edit_datetime) ?></td>
                <td>
                  <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['cliente/update', 'id' => $cliente->id], [
                      'class' => 'btn btn-warning',
                      'title' => Yii::t('app', 'Edit'),
                    ]) ?>

                  <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['cliente/delete', 'id' => $cliente->id], [
                      'class' => 'btn btn-danger',
                      'data-confirm' => Yii::t('app', 'Tem certeza que quer Deletar esse Cliente?'),
                      'data-method' => 'post',
                    ]) ?>
                </td>
              </tr>
              <tr id="product-row-<?= $cliente->id ?>" style="display: none; width: 100%;">
                <td colspan="4">
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
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
                          <tr class="product-row">
                            <td><?= Html::encode($produto->data) ?></td>
                            <td><?= Html::encode($produto->data_entrega) ?></td>
                            <td><?= Html::encode($produto->produto) ?></td>
                            <td><?= Html::encode($produto->quantidade) ?></td>
                            <td><?= Yii::$app->formatter->asCurrency($produto->valor_cliente) ?></td>
                            <td><?= Yii::$app->formatter->asCurrency($produto->valor_pagamento) ?></td>
                            <td>
                              <!-- Botão de Edição -->
                              <?= Html::button('<span class="glyphicon glyphicon-pencil"></span>', [
                                      'class' => 'btn btn-warning btn-sm edit-product-btn',
                                      'data-toggle' => 'modal',
                                      'data-target' => '#UpdateProductModal',
                                      'data-client-id' => $cliente->id,
                                      'data-cliente-nome' => $cliente->nome,
                                      'data-product-id' => Html::encode($produto->id),
                                      'data-date' => Html::encode($produto->data),
                                      'data-delivery-date' => Html::encode($produto->data_entrega),
                                      'data-product-name' => Html::encode($produto->produto),
                                      'data-quantity' => Html::encode($produto->quantidade),
                                      'data-client-value' => Html::encode($produto->valor_cliente),
                                      'data-payment-value' => Html::encode($produto->valor_pagamento),
                                    ]) ?>

                              <?= Html::a(
                                      '<span class="glyphicon glyphicon-trash"></span>',
                                      ['cliente/deleteproduct', 'id' => $produto->id],
                                      [
                                        'class' => 'btn btn-danger btn-sm',
                                        'data-confirm' => Yii::t('app', 'Tem certeza que quer Deletar esse Produto?'),
                                        'data-method' => 'post',
                                      ]
                                    ) ?>
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
                  <!-- Funcionalidades adicionais ao lado do botão -->
                  <form method="POST" action="update/<?= Html::encode($cliente->id) ?>">
                    <div class="col-md-6" style="width: 100%;">
                      <div class="additional-info additional-info-<?= $cliente->id ?> card mb-4"
                        style="border: 1px solid #007bff; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);">
                        <div class="card-header"
                          style="background-color: #007bff; color: white; border-radius: 10px 10px 0 0;">
                          <h5 class="card-title" style="margin: 0; font-weight: bold; text-align:center;">Informações do
                            Cliente</h5>
                        </div>
                        <div class="card-body"
                          style="padding: 2rem; background-color: #f9f9f9; border-radius: 0 0 10px 10px;">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-row">
                                <table class="table">
                                  <thead>
                                    <tr>
                                      <th style="font-weight: bold;">Descrição</th>
                                      <th style="font-weight: bold; text-align: right;">Valor</th>
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
                                    <tr class="product-row">
                                      <td style="font-weight: bold;">Quantidade Total:</td>
                                      <td style="color: #007bff; text-align: center;"><?= $totalQuantidade ?></td>
                                    </tr>
                                    <tr class="product-row">
                                      <td style="font-weight: bold;">Valor Total Cliente:</td>
                                      <td style="color: #28a745; text-align: center;">
                                        <?= Yii::$app->formatter->asCurrency($totalValorCliente) ?></td>
                                    </tr>
                                    <tr class="product-row">
                                      <td style="font-weight: bold;">Valor Total Revendedor:</td>
                                      <td style="color: #dc3545; text-align: center;">
                                        <?= Yii::$app->formatter->asCurrency($totalValorRevendedor) ?></td>
                                    </tr>
                                    <tr class="product-row">
                                      <td style="font-weight: bold;">Lucro:</td>
                                      <td style="color: #28a745; text-align: center;">
                                        <?= Yii::$app->formatter->asCurrency($lucro) ?></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                              <table class="table table-bordered table-striped table-hover">
                                <thead class="thead-dark">
                                  <tr>

                                  </tr>
                                </thead>

                                <tbody>
                                  <tr class="product-row">
                                    <td style="font-weight: bold;">Valor Total Cliente Dividido:</td>
                                    <td style="color: #007bff;" id="valor-total-dividido">
                                      <?php if (isset($totalValorCliente, $cliente->parcelas) && is_numeric($totalValorCliente) && is_numeric($cliente->parcelas) && $cliente->parcelas > 0): ?>
                                      <?= Yii::$app->formatter->asCurrency($totalValorCliente / $cliente->parcelas) ?>
                                      <?php else: ?>
                                      <span>N/A</span>
                                      <?php endif; ?>
                                    </td>
                                  </tr>
                                  <tr class="product-row">
                                    <td style="font-weight: bold;">Lucro Dividido:</td>
                                    <td style="color: #28a745;" id="lucro-dividido">
                                      <?php if (is_numeric($lucro) && is_numeric($cliente->parcelas) && $cliente->parcelas > 0): ?>
                                      <?= Yii::$app->formatter->asCurrency($lucro / $cliente->parcelas) ?>
                                      <?php else: ?>
                                      <span>N/A</span>
                                      <?php endif; ?>
                                    </td>
                                  </tr>
                                  <tr class="product-row">
                                    <td style="font-weight: bold;">Valor restante Cliente:</td>
                                    <td style="color: #007bff;" id="valor-total-dividido">
                                      <?php
                                        $descricaoValue = $cliente->descricao;
                                        // Verifica se a descrição é uma expressão matemática e a avalia
                                        if (isset($totalValorCliente) && is_numeric($totalValorCliente)):
                                          // Tenta calcular o valor da descrição, se for uma expressão matemática
                                          try {
                                            $valorDescricao = eval("return $descricaoValue;");
                                          } catch (ParseError $e) {
                                            $valorDescricao = 0; // Define um valor padrão em caso de erro
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

                                </tbody>

                              </table>


                            </div>
                            <div class="col-md-6">
                              <div class="form-row">
                                <div class="row mt-4">
                                  <div class="col-6">
                                    <?php if (!empty($dataProvider->models)): ?>
                                    <div class="product-row">
                                      <div class="form-group col-md-6">
                                        <label for="descricao">Descrição:</label>

                                        <?php if (!empty($cliente->descricao)): ?>
                                        <p id="descricao-<?= $cliente->id ?>" class="form-control stylish-dropdown">
                                          <?= Html::encode($cliente->descricao) ?>
                                        </p>
                                        <?php else: ?>
                                        <p>N/A</p>
                                        <?php endif; ?>
                                      </div>

                                      <div class="form-group col-md-6">
                                        <label for="parcelas">Parcelado em:</label>
                                        <?php if (!empty($cliente->parcelas)): ?>
                                        <p id="parcelas-<?= $cliente->id ?>" class="form-control stylish-dropdown">
                                          <?= Html::encode($cliente->parcelas) ?>
                                        </p>
                                        <?php else: ?>
                                        <p>N/A</p>
                                        <?php endif; ?>
                                      </div>
                                      <div class="form-group col-md-6">
                                        <label for="category_id">Forma de Pagamento:</label>
                                        <?php if (!empty($cliente) && !empty($cliente->category)): ?>
                                        <p id="category_id-<?= $cliente->id ?>" class="form-control stylish-dropdown">
                                          <?= Html::encode($cliente->category->desc_category) ?>
                                        </p>
                                        <?php else: ?>
                                        <p>N/A</p>
                                        <?php endif; ?>
                                      </div>
                                    </div>
                                    <?php else: ?>
                                    <p>Não há clientes disponíveis.</p>
                                    <?php endif; ?>
                                  </div> <!-- Fecha a div de col-6 para primeira coluna -->

                                  <div class="col-6">
                                    <!-- Abertura da segunda coluna -->
                                    <!-- Fecha a div de form-group col-md-6 -->

                                    <?= Html::button('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Add Product'), [
                                        'class' => 'btn btn-success btn-block',
                                        'style' => 'margin-top: 10px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);',
                                        'data-toggle' => 'modal',
                                        'data-target' => '#CreateProductModal',
                                        'data-cliente-id' => Html::encode($cliente->id),
                                        'data-cliente-nome' => Html::encode($cliente->nome),
                                      ]) ?>
                                  </div> <!-- Fecha a div de col-6 para segunda coluna -->

                                </div> <!-- Fecha a div de row mt-4 -->
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </td>
              </tr>

              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div id="product-details" style="margin-top: 20px;"></div>
      </div>
    </div>
  </div>
</div>
<!-- Modal para adicionar produtos -->
<div class="modal fade" id="CreateProductModal" tabindex="-1" role="dialog" aria-labelledby="CreateProductModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title w-100" id="CreateProductModalLabel" style="font-weight: bold; color: #fff;">Adicionar
          Produto</h5>
        <label>
          <p id="clienteIdDisplay" class="form-control-static"></p>
        </label>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="produtos-clientes-form">
          <?php $form = ActiveForm::begin(['id' => 'CreateProductForm', 'action' => ['cliente/create-product']]); ?>

          <div class="form-row">

            <div class="form-group col-md-6">
              <?= $form->field($model, 'clienteId')->hiddenInput(['id' => 'clienteId'])->label(false) ?>
            </div>

          </div>

          <div class="form-group col-md-6">
            <?= Html::label('User ID', 'userId', ['class' => 'control-label']) ?>
            <?= Html::textInput('userId', Yii::$app->user->id, ['id' => 'userId', 'class' => 'form-control text-center', 'readonly' => true]) ?>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <?= $form->field($model, 'data')->textInput(['id' => 'date', 'type' => 'date', 'class' => 'form-control text-center'])->label('Data do Pedido', ['class' => 'text-center']) ?>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <?= $form->field($model, 'data_entrega')->textInput(['id' => 'delivery-date', 'type' => 'date', 'class' => 'form-control text-center'])->label('Data de Entrega', ['class' => 'text-center']) ?>
            </div>
            <div class="form-group col-md-6">
              <?= $form->field($model, 'produto')->textInput(['id' => 'product-name', 'maxlength' => true, 'class' => 'form-control text-center'])->label('Nome do Produto', ['class' => 'text-center']) ?>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <?= $form->field($model, 'quantidade')->textInput(['id' => 'quantity', 'type' => 'number', 'min' => 0, 'class' => 'form-control text-center'])->label('Quantidade', ['class' => 'text-center']) ?>
            </div>
            <div class="form-group col-md-6">
              <?= $form->field($model, 'valor_cliente')->textInput(['id' => 'client-value', 'type' => 'number', 'step' => '0.01', 'min' => 0, 'class' => 'form-control text-center'])->label('Valor Cliente', ['class' => 'text-center']) ?>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <?= $form->field($model, 'valor_pagamento')->textInput(['id' => 'payment-value', 'type' => 'number', 'step' => '0.01', 'min' => 0, 'class' => 'form-control text-center'])->label('Valor Revendedor', ['class' => 'text-center']) ?>
            </div>
          </div>
          <div class="d-flex justify-content-center">
            <?= Html::submitButton('<i class="fa fa-floppy-o"></i> ' . Yii::t('app', 'Salvar'), ['class' => 'btn btn-primary mx-2', 'id' => 'saveProductButton']) ?>
            <button type="button" class="btn btn-secondary mx-2" data-dismiss="modal">Fechar</button>
          </div>
          <?php ActiveForm::end(); ?>
        </div>
      </div>
      <div class="modal-footer">
        <!-- Footer pode ser usado para mensagens adicionais, se necessário -->
      </div>
    </div>
  </div>
</div>
<!-- Modal para update produtos -->
<div class="modal fade" id="UpdateProductModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Atualizar Produto</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <?php $form = ActiveForm::begin([
          'id' => 'UpdateProductForm',
          'action' => ['cliente/update-product'], // Inclui o ID do produto na URL
          'method' => 'post',
        ]); ?>
        <?= Html::hiddenInput('product_id', null, ['id' => 'product-id']) ?>

        <div class="form-row">

          <div class="form-group col-md-6">
            <?= $form->field($model, 'clienteId')->hiddenInput(['id' => 'clienteId'])->label(false) ?>
            <!-- Campo oculto para o ID do Produto -->


            <?= $form->field($model, 'clienteId')->textInput(['id' => 'clienteId', 'type' => 'text', 'class' => 'form-control text-center'])->label('id', ['class' => 'text-center']) ?>
          </div>

        </div>


        <div class="form-group col-md-6">
          <?= Html::label('User ID', 'userId', ['class' => 'control-label']) ?>
          <?= Html::textInput('userId', Yii::$app->user->id, ['id' => 'userId', 'class' => 'form-control text-center', 'readonly' => true]) ?>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <?= $form->field($model, 'data')->textInput(['id' => 'date', 'type' => 'date', 'class' => 'form-control text-center'])->label('Data do Pedido', ['class' => 'text-center']) ?>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <?= $form->field($model, 'data_entrega')->textInput(['id' => 'delivery-date', 'type' => 'date', 'class' => 'form-control text-center'])->label('Data de Entrega', ['class' => 'text-center']) ?>
          </div>
          <div class="form-group col-md-6">
            <?= $form->field($model, 'produto')->textInput(['id' => 'product-name', 'maxlength' => true, 'class' => 'form-control text-center'])->label('Nome do Produto', ['class' => 'text-center']) ?>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <?= $form->field($model, 'quantidade')->textInput(['id' => 'quantity', 'type' => 'number', 'min' => 0, 'class' => 'form-control text-center'])->label('Quantidade', ['class' => 'text-center']) ?>
          </div>
          <div class="form-group col-md-6">
            <?= $form->field($model, 'valor_cliente')->textInput(['id' => 'client-value', 'type' => 'number', 'step' => '0.01', 'min' => 0, 'class' => 'form-control text-center'])->label('Valor Cliente', ['class' => 'text-center']) ?>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <?= $form->field($model, 'valor_pagamento')->textInput(['id' => 'payment-value', 'type' => 'number', 'step' => '0.01', 'min' => 0, 'class' => 'form-control text-center'])->label('Valor Revendedor', ['class' => 'text-center']) ?>
          </div>
        </div>
        <div class="d-flex justify-content-center">
          <?= Html::submitButton('<i class="fa fa-floppy-o"></i> ' . Yii::t('app', 'Salvar'), ['class' => 'btn btn-primary mx-2', 'id' => 'saveProductButton']) ?>
          <button type="button" class="btn btn-secondary mx-2" data-dismiss="modal">Fechar</button>
        </div>
        <?php ActiveForm::end(); ?>
      </div>
    </div>
    <div class="modal-footer">
      <!-- Footer pode ser usado para mensagens adicionais, se necessário -->
    </div>
  </div>
</div>
</div>
<script>
$(document).on('click', '.edit-product-btn', function(event) {
  const button = $(this); // Botão que abriu o modal
  const productId = button.data('product-id');
  const clientId = button.data('client-id');
  const clienteNome = button.data('cliente-nome'); // Obtém o nome do cliente
  // ID do produto
  const date = button.data('date');
  const deliveryDate = button.data('delivery-date');
  const productName = button.data('product-name');
  const quantity = button.data('quantity');
  const clientValue = button.data('client-value');
  const paymentValue = button.data('payment-value');

  console.log('Dados do botão:', button.data()); // Verifique todos os dados
  console.log('clientId:', clientId); // Verifique o valor do clientId
  $('#UpdateProductModal #product-id').val(productId);
  // Defina o valor do ID do cliente no campo oculto
  $('#UpdateProductModal #clienteId').val(clientId);
  $('#UpdateProductModal #clienteIdDisplay').text(clienteNome); // Exibe o nome do cliente

  $('#UpdateProductModal #product-name').val(productName);
  $('#UpdateProductModal #quantity').val(quantity);
  $('#UpdateProductModal #client-value').val(clientValue);
  $('#UpdateProductModal #payment-value').val(paymentValue);
  $('#UpdateProductModal #date').val(date);
  $('#UpdateProductModal #delivery-date').val(deliveryDate);
});

$(document).ready(function() {
  // Lógica para mostrar/ocultar a linha de produtos do cliente ao clicar
  $('.clickable-row').click(function() {
    const clientId = $(this).data('id');
    $('#product-row-' + clientId).toggle();
  });

  // Evento para quando o modal de criação de produto é exibido
  $('#CreateProductModal').on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget);
    const clientId = button.data('cliente-id');
    const clienteNome = button.data('cliente-nome');
    $('#clienteId').val(clientId);
    $('#clienteIdDisplay').text(clienteNome);
  });

  // Envio do formulário de criação de produto
  $('#CreateProductForm').on('beforeSubmit', function(e) {
    e.preventDefault();
    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: $(this).serialize(),
      dataType: 'json', // Define o tipo de dados esperados
      success: function(response) {
        if (response.success) {
          $('#CreateProductModal').modal('hide');
          alert(response.message); // Mostra a mensagem de sucesso

          // Recarrega a página após um pequeno atraso (opcional)
          setTimeout(function() {
            location.reload(); // Atualiza a página
          }, 1000); // Atraso de 1 segundo (1000 ms)
        } else {
          // Se ocorrerem erros, exiba uma mensagem apropriada
          alert('Erro ao salvar o produto: ' + JSON.stringify(response.errors));
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Erro ao salvar o produto. Detalhes: ' + errorThrown); // Mensagem de erro
      }
    });
    return false; // Previne o envio do formulário padrão
  });
});
</script>
<style>
/* Ajuste de contêiner para tabelas responsivas */
.table-container {
  width: 100%;
  overflow-x: hidden;
}

/* Ajuste das tabelas */
table {
  width: 100%;
  border-collapse: collapse;
  font-size: 1em;
  margin: 1em 0;
}

/* Melhora na aparência dos botões */
button {
  padding: 0.6em 1.2em;
  font-size: 1em;
  border-radius: 4px;
  border: none;
  background-color: #3498db;
  color: white;
  cursor: pointer;
}

button:hover {
  background-color: #2980b9;
}

/* Layout Geral */
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #f9f9f9;
  color: #333;
}

/* Modal */
.modal {
  z-index: 1050 !important;
}

.modal-backdrop {
  z-index: 1040 !important;
}

.modal-header {
  background-color: #007bff;
  color: white;
  border-bottom: 1px solid #dee2e6;
}

.modal-title {
  font-size: 1.5rem;
  font-weight: bold;
  text-align: center;
}

.modal-body {
  padding: 2rem;
}

.modal-content {
  border-radius: 10px;
}

/* Formulário */
.produtos-clientes-form {
  text-align: center;
  /* Centraliza o conteúdo do formulário */
}

.form-control {
  border-radius: 5px;
  box-shadow: none;
  border: 1px solid #ced4da;
  margin-bottom: 1rem;
  /* Espaçamento entre campos */
  transition: border-color 0.3s;
}

.form-control:focus {
  border-color: #007bff;
  /* Cor de foco do input */
}

/* Estilo dos rótulos do formulário */
.form-group label {
  font-weight: bold;
  text-align: center;
}

/* Botões personalizados */
.btn-custom {
  background-color: #28a745;
  color: white;
  border-radius: 5px;
  padding: 0.5em 1em;
  /* Tamanho do botão */
}

.btn-custom:hover {
  background-color: #218838;
}

/* Estilos dos botões primários e secundários */
.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
  border-radius: 5px;
  margin-right: 10px;
  /* Espaço entre os botões */
  font-size: 1.1em;
  /* Aumentar a fonte */
}

.btn-primary:hover {
  background-color: #0056b3;
}

.btn-secondary {
  background-color: #6c757d;
  border-color: #6c757d;
  border-radius: 5px;
}

.btn-secondary:hover {
  background-color: #5a6268;
}

/* Estilos adicionais */
.product-row {
  transition: background-color 0.3s, transform 0.3s;
}

.product-row:hover {
  background-color: #f8f9fa;
  transform: scale(1.02);
}

.alert {
  margin-top: 10px;
  border-radius: 5px;
}

.alert-dismissible .close {
  color: #fff;
  opacity: 0.8;
}

.alert-dismissible .close:hover {
  opacity: 1;
}

/* Estrutura de Cartões e Painéis */
.card {
  margin-bottom: 20px;
  border-radius: 5px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-header {
  background-color: #007bff;
  color: #fff;
  padding: 10px;
  border-radius: 5px 5px 0 0;
  font-weight: bold;
}

.card-body {
  padding: 15px;
  background-color: #fff;
  border-radius: 0 0 5px 5px;
}

/* Tabelas */
.table {
  width: 100%;
  margin-bottom: 20px;
  border-collapse: collapse;
  max-width: 100%;
  /* Para evitar que ultrapasse o limite do contêiner */
}

.table th,
.table td {
  padding: 12px;
  text-align: center;
  border-bottom: 1px solid #ddd;
}

.table th {
  background-color: #f1f1f1;
}

.table tbody tr:hover {
  background-color: #f5f5f5;
}

/* Contêiner da página */
.cliente-index {
  margin: 0 auto;
  /* Centraliza o contêiner horizontalmente */
  padding: 15px;
  /* Adiciona algum espaçamento */
}

/* Colunas responsivas */
.col-md-4,
.col-md-9 {
  flex: 0 0 auto;
  /* Para evitar que as colunas encolham */
  width: auto;
  /* Isso deve manter a coluna no tamanho necessário */
}
</style>