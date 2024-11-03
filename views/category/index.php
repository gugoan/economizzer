<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\icons\Icon;

$this->title = Yii::t('app', 'Categorias');
?>

<div class="category-index container mt-5 p-4 shadow-sm rounded bg-light">

  <!-- Título da página e botão de criação -->
  <h2 class="text-center mb-4" style="font-size: 2.6rem;">
    <span><?= Html::encode($this->title) ?></span>
    <?= Html::a('<i class="fa fa-plus"></i> Criar', ['/category/create'], ['class' => 'btn btn-primary grid-button float-right']) ?>
  </h2>
  <hr />

  <!-- Mensagens de alerta -->
  <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
  <?php $alertClass = substr($key, strpos($key, '-') + 1); ?>
  <div class="alert alert-dismissible alert-<?= $alertClass ?>" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span
        aria-hidden="true">&times;</span></button>
    <p><?= $message ?></p>
  </div>
  <?php endforeach; ?>

  <!-- GridView da tabela -->
  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-hover'],
        'summary' => '',
        'rowOptions' => function ($model, $index, $widget, $grid) {
            return [
                'id' => $model['id_category'],
                'onclick' => 'location.href="' . Yii::$app->urlManager->createUrl('category/') . '/"+(this.id);',
                'style' => "cursor: pointer",
            ];
        },
        'columns' => [
            [
                'attribute' => 'icone',
                'header' => '',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->icone ? '<i class="' . $model->icone . '"></i>' : '<i class="fa fa-tag"></i>';
                },
                'contentOptions' => ['style' => 'width: 3%; text-align:center'],
            ],
            [
                'attribute' => 'hexcolor_category',
                'header' => '',
                'format' => 'raw',
                'value' => function ($model) {
                    return '<strong style="color:' . $model->hexcolor_category . '"><i class="fa fa-tag"></i></strong>';
                },
                'contentOptions' => ['style' => 'width: 3%; text-align:center'],
            ],
            [
                'attribute' => 'parent_id',
                'header' => 'Hierarquia',
                'format' => 'raw',
                'enableSorting' => true,
                'value' => function ($model) {
                    return $model->parent ? $model->parent->desc_category . " > " . $model->desc_category : "<span class=\"text-danger\"><em>" . $model->desc_category . "</em></span>";
                },
                'contentOptions' => ['style' => 'width: 20%; text-align:left'],
            ],
            'descricao_detalhada:ntext',
            [
                'attribute' => 'tipo',
                'value' => function ($model) {
                    return ucfirst(Yii::t('app', $model->tipo));
                },
                'contentOptions' => ['style' => 'width: 10%; text-align:center'],
            ],
            'tags',
            [
                'attribute' => 'limite_orcamento',
                'format' => 'currency',
                'contentOptions' => ['style' => 'width: 10%; text-align:right'],
            ],
            [
                'attribute' => 'compartilhavel',
                'format' => 'boolean',
                'value' => function ($model) {
                    return $model->compartilhavel == 1;
                },
                'contentOptions' => ['style' => 'width: 5%; text-align:center'],
            ],
            [
                'attribute' => 'id_bancos',
                'header' => 'Banco',
                'value' => function ($model) {
                    return $model->banco ? $model->banco->nome : 'Nenhum';
                },
                'contentOptions' => ['style' => 'width: 10%; text-align:center'],
            ],
            [
                'attribute' => 'id_clientes',
                'header' => 'Cliente',
                'value' => function ($model) {
                    return $model->cliente ? $model->cliente->nome : 'Nenhum';
                },
                'contentOptions' => ['style' => 'width: 10%; text-align:center'],
            ],
            [
                'attribute' => 'id_produtos_clientes',
                'header' => 'Produto/Cliente',
                'value' => function ($model) {
                    return $model->produtoCliente ? $model->produtoCliente->nome_produto : 'Nenhum';
                },
                'contentOptions' => ['style' => 'width: 10%; text-align:center'],
            ],
            [
                'header' => 'Açoes',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-edit hidden-xs"></span>',
                            $url,
                            [
                                'title' => 'Atualizar',
                                'data-pjax' => '0',
                            ]
                        );
                    },
                    'delete' => function ($url) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash hidden-xs"></span>',
                            $url,
                            [
                                'title' => 'Excluir',
                                'data-pjax' => '0',
                                'data-method' => 'post',
                                'data-confirm' => 'Tem certeza de que deseja excluir este item?',
                            ]
                        );
                    },
                ],
                'contentOptions' => ['style' => 'width: 15%; text-align:right'],
            ],
        ],
    ]); ?>
</div>

<!-- CSS Customizado -->
<style>
/* Botão de criar */
.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
  transition: background-color 0.3s ease, transform 0.3s ease;
}

.btn-primary:hover {
  background-color: #0056b3;
  transform: scale(1.05);
}

/* Tabela */
.table {
  border: 1px solid #ddd;
  border-radius: 5px;
  overflow: hidden;
  font-size: 1.7rem;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: #f9f9f9;
}

.table-hover tbody tr {
  transition: all 0.3s ease;
}

.table-hover tbody tr:hover {
  background-color: #e9ecef;
  transform: scale(1.02);
}

.alert {
  margin-bottom: 20px;
}

h2 {
  margin: 0;
  color: #007bff;
}

.category-index {
  margin-top: 20px;
}
</style>