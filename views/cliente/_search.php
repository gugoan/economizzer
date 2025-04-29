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
<div class="clientes-index container" style="padding: 20px; background-color: #f8f9fa;">

  <div class="clientes-search card mb-4" style="border: 1px solid #ddd; border-radius: 8px;">
    <div class="card-header" style="background-color: #007bff; color: #fff;">
      <h5 class="mb-0">Buscar Clientes</h5>
    </div>
    <div class="card-body">

      <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'search-form'],
      ]); ?>

      <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-3">
          <?= $form->field($searchModel, 'id')->textInput([
            'placeholder' => 'ID',
            'style' => 'width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;'
          ])->label(false) ?>
        </div>
        <div class="col-md-3">
          <?= $form->field($searchModel, 'nome')->textInput([
            'placeholder' => 'Nome',
            'style' => 'width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;'
          ])->label(false) ?>
        </div>
        <div class="col-md-3">
          <?= $form->field($searchModel, 'user_id')->textInput([
            'placeholder' => 'User ID',
            'style' => 'width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;'
          ])->label(false) ?>
        </div>
        <div class="col-md-3">
          <?= $form->field($searchModel, 'data_registro')->input('date', [
            'style' => 'width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;'
          ])->label(false) ?>
        </div>
      </div>

      <div class="form-group text-center">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary me-2', 'style' => 'padding: 10px 20px; font-size: 0.9em;']) ?>
        <?= Html::resetButton('Limpar', ['class' => 'btn btn-outline-secondary', 'style' => 'padding: 10px 20px; font-size: 0.9em;']) ?>
      </div>

      <?php ActiveForm::end(); ?>

    </div>
  </div>

</div>