<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Faturas */

$this->title = 'Detalhes da Fatura';
$this->params['breadcrumbs'][] = ['label' => 'Faturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faturas-view container">

  <!-- Título e Ações -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="flex-grow-1 text-center"><?= Html::encode($this->title) ?></h1>
    <div class="text-right mb-4">
      <?= Html::a('Atualizar', ['update', 'id' => $model->id_fatura], ['class' => 'btn btn-primary']) ?>
      <?= Html::a('Excluir', ['delete', 'id' => $model->id_fatura], [
        'class' => 'btn btn-danger',
        'data-confirm' => 'Tem certeza de que deseja excluir esta fatura?',
        'data-method' => 'post',
      ]) ?>
    </div>
  </div>

  <!-- Detalhes da Fatura com Design Moderno -->
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          'id_fatura',
          [
            'attribute' => 'id_bancos',
            'label' => 'Banco',
            'value' => Html::a($model->banco->nome, ['bancos/view', 'id' => $model->id_bancos], ['class' => 'text-decoration-none']),
            'format' => 'raw',
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
            'label' => 'Categoria',
            'value' => Html::a($model->category->desc_category, ['category/view', 'id' => $model->category_id], ['class' => 'text-decoration-none']),
            'format' => 'raw',
          ],
          [
            'attribute' => 'parcelas',
            'label' => 'Parcelamento',
            'value' => $model->parcelas,
          ],
          [
            'attribute' => 'user_id',
            'label' => 'Usuário',
            'value' => $model->user->username,
          ],
        ],
        'options' => ['class' => 'table table-bordered table-hover table-striped text-center'],
      ]) ?>
    </div>
  </div>

  <style>
  /* Estilos para a página de detalhes da fatura */
  .faturas-view h1 {
    font-size: 2rem;
    color: #007bff;
    margin-bottom: 20px;
  }

  .btn-group .btn {
    font-size: 1.1rem;
    padding: 10px 20px;
    margin-right: 10px;
    transition: all 0.3s ease;
    border-radius: 6px;
  }

  .btn-primary:hover,
  .btn-danger:hover {
    transform: scale(1.08);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
  }

  .card {
    border-radius: 12px;
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.12);
    background: linear-gradient(135deg, #f9f9f9, #e3f2fd);
  }

  .card-body {
    padding: 30px;
    background-color: #f9f9f9;
    border-radius: 0 0 12px 12px;
  }

  /* Links estilizados */
  .text-decoration-none {
    color: #007bff;
    text-decoration: none;
    font-weight: 600;
  }

  .text-decoration-none:hover {
    text-decoration: underline;
    color: #0056b3;
  }

  /* Efeito de expansão e cor de fundo na tabela */
  .table {
    font-size: 1.5rem;
    margin-bottom: 0;
  }

  .table-bordered th,
  .table-bordered td {
    border: 1px solid #ddd;
    padding: 14px;
    transition: all 0.3s ease;
  }

  .table-hover tbody tr:hover {
    background-color: #e3f2fd;
    transform: scale(1.01);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  /* Sombras e transições para os botões */
  .btn-group .btn {
    transition: box-shadow 0.3s ease, transform 0.3s ease;
  }
  </style>
</div>