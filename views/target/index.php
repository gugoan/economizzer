<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('app', 'Goals');
?>

<div class="target-index">
  <h2>
    <span><?= Html::encode($this->title) ?></span>
    <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Create'), ['/target/create'], ['class' => 'btn btn-primary grid-button pull-right']) ?>
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
    'summary' => '',
    'rowOptions' => function ($model, $index, $widget, $grid) {
      return [
        'id' => $model['id'],
        'onclick' => 'location.href="' . Yii::$app->urlManager->createUrl('target/') . '/"+(this.id);',
        'style' => "cursor: pointer",
      ];
    },
    'columns' => [
      [
        'attribute' => 'title',
        'header' => Yii::t('app', 'Title'),
        'contentOptions' => ['style' => 'width: 60%; text-align:left'],
      ],
      [
        'attribute' => 'due_date',
        'header' => Yii::t('app', 'Due Date'),
        'format' => ['date', 'd/M/Y'],
        'contentOptions' => ['style' => 'width: 20%; text-align:center'],
      ],
      [
        'attribute' => 'status',
        'header' => Yii::t('app', 'Status'),
        'value' => function ($model) {
          return $model->status ? Yii::t('app', 'Achieved') : Yii::t('app', 'Pending');
        },
        'contentOptions' => ['style' => 'width: 10%; text-align:center'],
      ],
      [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{update} {delete}',
        'buttons' => [
          'update' => function ($url) {
            return Html::a(
              '<span class="glyphicon glyphicon-edit hidden-xs"></span>',
              $url,
              [
                'title' => Yii::t('app', 'Update'),
                'data-pjax' => '0',
              ]
            );
          },
          'delete' => function ($url) {
            return Html::a(
              '<span class="glyphicon glyphicon-trash hidden-xs"></span>',
              $url,
              [
                'title' => Yii::t('app', 'Delete'),
                'data-pjax' => '0',
                'data-method' => 'post',
              ]
            );
          },
        ],
        'contentOptions' => ['style' => 'width: 10%; text-align:right'],
      ],
    ],
  ]); ?>
</div>