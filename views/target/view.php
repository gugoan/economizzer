<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = Yii::t('app', 'Goal') . " #" . $model->id;
?>
<div class="target-view">

  <h2><?= Html::encode($this->title) ?></h2>
  <hr />
  <h2 class="pull-right">

    <?= Html::a(
      '<i class="fa fa-pencil-square-o"></i> ' . Yii::t('app', 'Update'),
      ['update', 'id' => $model->id],
      [
        'class' => 'btn btn-primary',
      ]
    ) ?>
    <?= Html::a(
      '<i class="fa fa fa-clone"></i> ' . Yii::t('app', 'Clone'),
      ['clone', 'id' => $model->id],
      [
        'class' => 'btn btn-primary',
      ]
    ) ?>
    <?= Html::a('<i class="glyphicon glyphicon-trash"></i> ' . Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
      'class' => 'btn btn-danger',
      'data' => [
        'confirm' => Yii::t('app', 'Are you sure you want to delete?'),
        'method' => 'post',
      ],
    ]) ?>

  </h2>

  <!-- Alerts -->
  <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
    <?php $alertClass = substr($key, strpos($key, '-') + 1); ?>
    <div class="alert alert-dismissible alert-<?= $alertClass ?>" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
          aria-hidden="true">&times;</span></button>
      <p><?= $message ?></p>
    </div>
  <?php endforeach ?>

  <h1 class="text-hide">Custom heading</h1>

  <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
      [
        'attribute' => 'value',
        'format' => 'raw',
        'value' => '<span class="label label-success">' . Yii::t('app', '$') . " " . $model->value . '</span>'
      ],
      [
        'attribute' => 'category_id',
        'value' => $model->category->desc_category,
      ],
      [
        'attribute' => 'date',
        'format' => ['date', 'd/M/Y'],
      ],
      'description',
      [
        'attribute' => 'is_pending',
        'format' => 'raw',
        'value' => $model->is_pending == 1 ? '<span class="label label-warning">' . Yii::t('app', 'Yes') . '</span>' : Yii::t('app', 'No'),
      ],
      [
        'attribute' => 'inc_datetime',
        'value' => Yii::$app->formatter->asDate($model->inc_datetime, 'long'),
      ],
      [
        'attribute' => 'edit_datetime',
        'value' => Yii::$app->formatter->asDate($model->edit_datetime, 'long'),
      ],
    ],
  ]) ?>

</div>