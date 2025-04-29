<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use app\models\Clientes;
use app\models\ClientesSearch;
use app\models\ProdutosClientes;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class ClienteController extends Controller
{
  public function actionIndex()
  {
    $searchModel = new ClientesSearch();
    $model = new ProdutosClientes();

    // No controlador, ao configurar o dataProvider, filtre pelo user_id
    $user_id = Yii::$app->user->id; // Obtenha o user_id do usuário logado
    $dataProvider = new ActiveDataProvider([
      'query' => Clientes::find()->where(['user_id' => $user_id]),
      'pagination' => [
        'pageSize' => 10, // Ajuste conforme necessário
      ],
    ]);

    $clienteId = Yii::$app->request->get('cliente_id');

    // Carrega o cliente específico com a categoria associada
    $cliente = Clientes::find()
      ->joinWith('category') // Associa a tabela de categorias
      ->where(['clientes.id' => $clienteId])
      ->one();

    // Obter a lista de clientes para o modal de copiar produto
    $clientes = Clientes::find()->select(['id', 'nome'])->asArray()->all();

    // Carrega os produtos do cliente diretamente do banco de dados, sem cache
    $produtos = [];
    if ($clienteId) {
      $produtos = ProdutosClientes::find()->where(['cliente_id' => $clienteId])->noCache()->all();
    }

    // Verifica se os dados do formulário foram enviados (salvamento de cliente e produtos)
    if (Yii::$app->request->isPost) {
      // Obtém os dados do formulário
      $parcelas = Yii::$app->request->post('parcelas');
      $formaPagamento = Yii::$app->request->post('forma_pagamento');
      $descricao = Yii::$app->request->post('descricao-' . $clienteId);
      $data = Yii::$app->request->post('data-' . $clienteId);
      $paid = Yii::$app->request->post('pago-' . $clienteId);  // Recebe os status de pagamento

      // Somando as descrições (se mais de uma for selecionada)
      $descricaoTotal = implode(', ', array_filter($descricao));  // Junta as descrições selecionadas em uma única string

      // Atualizando os dados do cliente
      $cliente->parcelas = $parcelas;
      $cliente->descricao = $descricaoTotal;  // Salva as descrições somadas
      $cliente->category_id = $formaPagamento;  // Forma de pagamento salva como category_id
      $cliente->data_registro = date('Y-m-d');  // Data de registro atual

      // Salvando no banco de dados
      if ($cliente->save()) {
        // Apenas salvando os dados no cliente, sem mexer em produtos_clientes
        echo "Cliente atualizado com sucesso!";
      } else {
        echo "Erro ao atualizar cliente!";
      }
    }

    // Passa as variáveis para a view
    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      'clientes' => $clientes,
      'cliente' => $cliente,
      'produtos' => $produtos,
      'clienteId' => $clienteId,
      'model' => $model, // Passando para a view
    ]);
  }

  public function actionCopyProduct()
  {
    Yii::$app->response->format = Response::FORMAT_JSON;

    $request = Yii::$app->request;
    if ($request->isPost) {
      $productId = $request->post('product_id');
      $targetClienteId = $request->post('target_cliente_id');
      $quantidade = $request->post('copy_quantity');
      $dataPedido = $request->post('copy_data_pedido');
      $dataEntrega = $request->post('copy_data_entrega');
      $produtoNome = $request->post('copy_produto_nome');
      $valorCliente = $request->post('copy_valor_cliente');
      $valorPagamento = $request->post('copy_valor_revendedor');

      // Validar dados
      if (empty($targetClienteId) || empty($produtoNome)) {
        return ['success' => false, 'message' => 'Dados inválidos.'];
      }

      // Verificar se o cliente de destino existe
      $clienteDestino = Clientes::findOne($targetClienteId);
      if (!$clienteDestino) {
        return ['success' => false, 'message' => 'Cliente de destino não encontrado.'];
      }

      // Encontrar o produto original (opcional, dependendo da lógica)
      $originalProduct = ProdutosClientes::findOne($productId);
      if (!$originalProduct) {
        return ['success' => false, 'message' => 'Produto original não encontrado.'];
      }

      // Criar um novo produto com as informações copiadas
      $newProduct = new ProdutosClientes();
      $newProduct->cliente_id = $targetClienteId;
      $newProduct->produto = $produtoNome;
      $newProduct->quantidade = $quantidade;
      $newProduct->data = $dataPedido;
      $newProduct->data_entrega = $dataEntrega;
      $newProduct->valor_cliente = $valorCliente;
      $newProduct->valor_pagamento = $valorPagamento;

      if ($newProduct->save()) {
        return ['success' => true, 'message' => 'Produto copiado com sucesso.'];
      } else {
        return ['success' => false, 'message' => 'Erro ao salvar o produto copiado.'];
      }
    }

    return ['success' => false, 'message' => 'Requisição inválida.'];
  }

  public function actionUpdateProduct()
  {
    $productId = Yii::$app->request->post('product_id'); // Obtém o ID do produto do POST
    if (!$productId) {
      throw new BadRequestHttpException("Parâmetro obrigatório: product_id");
    }

    $model = ProdutosClientes::findOne($productId);
    if ($model === null) {
      throw new NotFoundHttpException("Produto não encontrado.");
    }

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      Yii::$app->session->setFlash('success', 'Produto atualizado com sucesso.');
      return $this->redirect(['index']);
    }

    return $this->render('update', [
      'model' => $model,
    ]);
  }
  public function actionUpdate($id)
  {
    $model = $this->findModel($id); // Encontrar o modelo do cliente pelo ID

    // Carregar os dados do POST e validar o modelo
    if ($model->load(Yii::$app->request->post())) {
      // Validar o modelo
      if ($model->validate()) {
        // Salvar o modelo e redirecionar para a lista
        if ($model->save()) {
          return $this->redirect(['index']);
        }
      }
    }

    // Renderizar o formulário, mesmo em caso de erro
    return $this->render('_form', [
      'model' => $model,
    ]);
  }

  public function actionDeleteClient($id)
  {
    // Encontrar o cliente pelo ID
    $cliente = Clientes::findOne($id);

    if ($cliente) {
      // Encontrar todos os produtos associados ao cliente
      $produtos = ProdutosClientes::find()->where(['cliente_id' => $id])->all();

      // Excluir cada produto associado ao cliente
      foreach ($produtos as $produto) {
        $this->actionDeleteproduct($produto->id); // Chamar a função de exclusão de produto
      }

      // Agora, excluir o cliente
      if ($cliente->delete()) {
        Yii::$app->session->setFlash('success', 'Cliente e produtos deletados com sucesso.');
      } else {
        Yii::$app->session->setFlash('error', 'Erro ao deletar o cliente.');
      }
    } else {
      Yii::$app->session->setFlash('error', 'Cliente não encontrado.');
    }

    return $this->redirect(['index']);
  }

  public function actionDelete($id)
  {
    if (Yii::$app->request->isPost) {
      return $this->actionDeleteClient($id);
    }
    throw new BadRequestHttpException('Invalid request');
  }

  public function actionDeleteproduct($id)
  {
    $produtoCliente = ProdutosClientes::findOne($id);

    if ($produtoCliente) {
      $produtoCliente->delete();
      Yii::$app->session->setFlash('success', 'Produto deletado com sucesso.');
    } else {
      Yii::$app->session->setFlash('error', 'Produto não encontrado.');
    }

    return $this->redirect(['index']);
  }

  public function actionCreate()
  {
    $model = new Clientes();

    if ($model->load(Yii::$app->request->post())) {
      $model->user_id = Yii::$app->user->id;

      if ($model->save()) {
        return $this->redirect(['index']);
      } else {
        Yii::$app->session->setFlash('error', 'Erro ao salvar o cliente.');
      }
    }

    return $this->render('create', [
      'model' => $model,
    ]);
  }

  public function actionListarProdutos()
  {
    $clientId = Yii::$app->request->get('clientId');
    $produtos = ProdutosClientes::find()->where(['cliente_id' => $clientId])->noCache()->all();

    if ($produtos) {
      return $this->renderPartial('_lista_produtos', ['produtos' => $produtos]);
    }

    return '<p>Nenhum produto encontrado.</p>';
  }

  public function actionCreateProduct()
  {
    $model = new ProdutosClientes();

    if (Yii::$app->request->isAjax) {
      if ($model->load(Yii::$app->request->post())) {
        $model->cliente_id = Yii::$app->request->post('ProdutosClientes')['clienteId'];
        $model->user_id = Yii::$app->user->id;

        if ($model->save()) {
          // Retornar resposta de sucesso em formato JSON
          return $this->asJson([
            'success' => true,
            'message' => 'Produto salvo com sucesso.',
          ]);
        } else {
          // Retornar erros de validação
          return $this->asJson([
            'success' => false,
            'errors' => $model->getErrors(),
          ]);
        }
      }
    }

    // Se não for uma requisição AJAX, renderiza a página padrão
    return $this->render('index', [
      'model' => $model,
    ]);
  }


  public function actionProdutos($id)
  {
    $produtos = ProdutosClientes::find()->where(['cliente_id' => $id])->noCache()->all();
    return $this->renderPartial('_produtos', [
      'produtos' => $produtos,
    ]);
  }

  protected function findModel($id)
  {
    $model = Clientes::findOne(['id' => $id, 'user_id' => Yii::$app->user->id]);

    if ($model === null) {
      throw new NotFoundHttpException("Cliente não encontrado.");
    }

    return $model;
  }
}