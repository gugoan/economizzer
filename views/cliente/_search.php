<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-index container">

  <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

  <div class="clientes-search card mb-4">
    <div class="card-header">
      <h5 class="mb-0">Buscar Clientes</h5>
    </div>
    <div class="card-body">

      <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'search-form'],
      ]); ?>

      <div class="row">
        <div class="col-md-3">
          <?= $form->field($searchModel, 'id')->textInput(['placeholder' => 'ID'])->label(false) ?>
        </div>
        <div class="col-md-3">
          <?= $form->field($searchModel, 'nome')->textInput(['placeholder' => 'Nome'])->label(false) ?>
        </div>
        <div class="col-md-3">
          <?= $form->field($searchModel, 'user_id')->textInput(['placeholder' => 'User ID'])->label(false) ?>
        </div>
        <div class="col-md-3">
          <?= $form->field($searchModel, 'data_registro')->input('date')->label(false) ?>
        </div>
      </div>

      <div class="form-group text-center">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary me-2']) ?>
        <?= Html::resetButton('Limpar', ['class' => 'btn btn-outline-secondary']) ?>
      </div>

      <?php ActiveForm::end(); ?>

    </div>
  </div>



</div>