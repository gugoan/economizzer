<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Cashbook;

$this->title = Yii::t('app', 'Entries');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
  <div class="col-sm-3">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <strong><?php echo Yii::t('app', 'Filters'); ?>
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFilter" aria-expanded="true"
              aria-controls="collapseFilter">
              <span class="glyphicon glyphicon-resize-small pull-right" aria-hidden="true"></span>
            </a>
          </strong>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-9">

    <div class="cashbook-index">
      <h2>
        <span><?= Html::encode($this->title) ?></span>
        <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Create'), ['/cashbook/create'], [
          'class' => 'btn btn-primary grid-button pull-right',
          'style' => 'transition: transform 0.3s, background-color 0.3s;',
          'onmouseover' => 'this.style.backgroundColor="#0056b3"; this.style.transform="scale(1.05)";',
          'onmouseout' => 'this.style.backgroundColor="#343a40"; this.style.transform="scale(1)";'
        ]) ?>
        <?= Html::a('<i class="fa fa-upload"></i> ' . Yii::t('app', 'Upload PDF'), ['pdf-upload/upload'], [
          'class' => 'btn btn-secondary pull-right',
          'style' => 'margin-right: 10px; transition: transform 0.3s, background-color 0.3s;',
          'onmouseover' => 'this.style.backgroundColor="#6c757d"; this.style.transform="scale(1.05)";',
          'onmouseout' => 'this.style.backgroundColor="#0000"; this.style.transform="scale(1)";'
        ]) ?>
      </h2>
      <hr />

      <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
        <?php $alertClass = substr($key, strpos($key, '-') + 1); ?>
        <div class="alert alert-dismissible alert-<?= $alertClass ?>" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
          <p><?= $message ?></p>
        </div>
      <?php endforeach ?>

      <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-hover'],
        'emptyText'    => '</br><p class="text-danger">' . Yii::t('app', 'No entries found!') . '</p>',
        'summary'      =>  '',
        'showFooter'   => true,
        'showOnEmpty'  => false,
        'footerRowOptions' => ['style' => 'font-weight:bold;'],
        'rowOptions'   => function ($model, $index, $widget, $grid) {
          return [
            'id' => $model['id'],
            'onclick' => 'location.href="'
              . Yii::$app->urlManager->createUrl('cashbook/')
              . '/"+(this.id);',
            'style' => "cursor: pointer; transition: background-color 0.3s; ",
          ];
        },
        'columns'    => [
          [
            'attribute' => 'date',
            'enableSorting' => true,
            'value' => function ($model) {
              return $model->date <> '' ? Yii::$app->formatter->asDate($model->date, 'short') : Yii::$app->formatter->asDate($model->date, 'short');
            },
            'contentOptions' => ['style' => 'width: 15%;text-align:left'],
          ],
          [
            'attribute' => 'category_id',
            'format' => 'raw',
            'enableSorting' => true,
            'value' => function ($model) {
              return $model->description <> '' ? '<span style="color:' . $model->category->hexcolor_category . '">' . $model->category->desc_category . '</span>' . ' <em class="text-muted">(' . $model->description . ')</em>' : '<span style="color:' . $model->category->hexcolor_category . '">' . $model->category->desc_category . '</span>';
            },
            'contentOptions' => ['style' => 'width: 55%;text-align:left'],
            'footer' => 'Total',
            'footerOptions' => ['style' => 'text-align:left'],
          ],
          [
            'label' => '',
            'attribute' => 'value',
            'format' => 'raw',
            'value' => function ($model) {
              return $model->is_pending === 0 ? '<strong style="color:' . $model->type->hexcolor_type . '">' . ' ' . $model->value . '</strong>' :
                '<span class="glyphicon glyphicon-flag" style="color:orange" aria-hidden="true"></span> <strong style="color:' . $model->type->hexcolor_type . '">' . ' ' . $model->value . '</strong>';
            },
            'enableSorting' => true,
            'contentOptions' => ['style' => 'width: 30%;text-align:right'],
            'footer' => Cashbook::pageTotal($dataProvider->models, 'value'),
            'footerOptions' => ['style' => 'text-align:right'],
          ],
          [
            'label' => '',
            'format' => 'raw',
            'value' => function ($model) {
              return $model->is_pending <> 0 ? '<span class="glyphicon glyphicon-flag" style="color:orange" aria-hidden="true"></span>' : '';
            },
          ],
          // Adicionando a coluna de ação
          [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Ações',
            'template' => '{update} {delete}', // Adicionando o botão de excluir
            'buttons' => [
              'update' => function ($url, $model) {
                return Html::a(
                  '<span class="glyphicon glyphicon-pencil"></span>',
                  ['cashbook/update', 'id' => $model->id],
                  [
                    'title' => Yii::t('app', 'Edit'),
                    'aria-label' => Yii::t('app', 'Edit'),
                    'data-pjax' => '0', // Se você estiver usando Pjax
                  ]
                );
              },
              'delete' => function ($url, $model) {
                return Html::a(
                  '<span class="glyphicon glyphicon-trash"></span>',
                  ['cashbook/delete', 'id' => $model->id],
                  [
                    'title' => Yii::t('app', 'Delete'),
                    'aria-label' => Yii::t('app', 'Delete'),
                    'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), // Mensagem de confirmação
                    'data-method' => 'post', // Enviando a solicitação como POST
                    'data-pjax' => '0', // Se você estiver usando Pjax
                  ]
                );
              },
            ],
          ],
        ],
      ]); ?>
      <hr />
    </div>
  </div>
</div>

<style>
  .table-hover tbody tr:hover {
    background-color: #f5f5f5;
    /* Cor de fundo ao passar o mouse */
    transform: scale(1.02);
    /* Aumentar o tamanho da linha */
    transition: background-color 0.3s, transform 0.3s;
    /* Transição suave */
  }
</style>