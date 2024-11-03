<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\icons\Icon;

$this->title = $model->desc_category;
?>
<div class="category-view container mt-5 p-4 shadow-sm rounded bg-light">
  <h2 class="text-center mb-4" style="font-size: 2.6rem;"><?= Html::encode($this->title) ?></h2>

  <div class="text-center mb-4">
    <div class="btn-group" role="group">
      <?= Html::a('<i class="fa fa-pencil"></i> ' . Yii::t('app', 'Update'), ['update', 'id' => $model->id_category], [
                'class' => 'btn btn-outline-primary btn-lg custom-btn',
                'style' => 'background-color: #007bff; color: #fff;',
            ]) ?>
      <?= Html::a('<i class="fa fa-trash"></i> ' . Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_category], [
                'class' => 'btn btn-outline-danger btn-lg custom-btn',
                'style' => 'background-color: #dc3545; color: #fff;',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete?'),
                    'method' => 'post',
                ],
            ]) ?>

    </div>
  </div>

  <div class="table-wrapper mt-3">
    <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-hover table-modern'],
            'attributes' => [
                'desc_category',
                [
                    'attribute' => 'hexcolor_category',
                    'format' => 'raw',
                    'value' => '<strong style="color:' . $model->hexcolor_category . '"><i class="fa fa-tag"></i></strong>',
                ],
                [
                    'attribute' => 'icone',
                    'format' => 'raw',
                    'value' => $model->icone ? '<i class="' . $model->icone . '"></i>' : Yii::t('app', 'No Icon'),
                ],
                'descricao_detalhada:ntext',
                [
                    'attribute' => 'tipo',
                    'value' => ucfirst(Yii::t('app', $model->tipo)),
                ],
                'limite_orcamento:currency',
                [
                    'attribute' => 'compartilhavel',
                    'format' => 'raw',
                    'value' => $model->compartilhavel ? Yii::t('app', 'Yes') : Yii::t('app', 'No'),
                ],
                'tags',
                [
                    'attribute' => 'parent_id',
                    'format' => 'raw',
                    'value' => $model->parent ? $model->parent->desc_category : Yii::t('app', 'None'),
                ],
                [
                    'attribute' => 'id_bancos',
                    'value' => $model->banco ? $model->banco->nome : Yii::t('app', 'None'),
                ],
                [
                    'attribute' => 'id_clientes',
                    'value' => $model->cliente ? $model->cliente->nome : Yii::t('app', 'None'),
                ],
                [
                    'attribute' => 'id_produtos_clientes',
                    'value' => $model->produtoCliente ? $model->produtoCliente->nome_produto : Yii::t('app', 'None'),
                ],
                [
                    'attribute' => 'is_active',
                    'format' => 'raw',
                    'value' => $model->is_active == 1 ? Yii::t('app', 'Yes') : Yii::t('app', 'No'),
                ],
                [
                    'attribute' => 'historico_alteracoes',
                    'format' => 'ntext',
                    'value' => $model->historico_alteracoes ? $model->historico_alteracoes : Yii::t('app', 'No changes recorded'),
                ],
            ],
        ]) ?>
  </div>
</div>

<!-- CSS Customizado -->
<style>
/* Container geral */
.category-view {
  background-color: #ffffff;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  position: relative;
}

/* Estilo dos botões */
.custom-btn {
  font-size: 1.9rem;
  /* Tamanho da fonte */
  border-radius: 10px;
  font-weight: bold;
  padding: 8px 20px;
  margin: 0 5px;
  /* Espaçamento horizontal */
  transition: transform 0.3s ease;
}

/* Estilo da tabela */
.table-modern tr {
  transition: all 0.3s ease;
  /* Transição suave */
}

.table-modern tr:hover {
  background-color: #d9f2ff;
  /* Cor de fundo ao passar o mouse */
  transform: scale(1.02);
  /* Expansão leve */
}


.table-wrapper {
  margin-top: 20px;
  /* Espaçamento de 20px acima da tabela */
  margin-bottom: 20px;
  /* Espaçamento de 20px abaixo da tabela */
}

.custom-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Estilo da tabela */
.table-modern {
  width: 80%;
  /* Reduz a largura da tabela */
  margin: 0 auto;
  background-color: #f9f9f9;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.table-modern th,
.table-modern td {
  padding: 8px 12px;
  /* Compactação */
  text-align: center;
  /* Centralização do texto */
  border-bottom: 1px solid #e0e0e0;
  font-size: 1.7rem;
  /* Tamanho da fonte */
}

.table-modern th {
  background-color: #007bff;
  color: #fff;
  font-weight: 600;
}

.table-modern tr:hover {
  background-color: #e6f7ff;
  transition: all 0.3s ease;
}

/* Remover a borda inferior da última linha */
.table-modern tr:last-child td {
  border-bottom: none;
}
</style>