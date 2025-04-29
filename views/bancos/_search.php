<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Bancos;
use kartik\widgets\DatePicker;

?>
<!-- Modal de Pesquisa -->
<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <!-- Modal grande para acomodar mais campos -->
    <div class="modal-content">
      <!-- Cabeçalho do Modal -->
      <div class="modal-header">
        <h5 class="modal-title" id="searchModalLabel"><?= Yii::t('app', 'Pesquisar Bancos') ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Corpo do Modal -->
      <div class="modal-body">
        <div class="bancos-search">
          <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => ['class' => 'search-form'],
          ]); ?>

          <div class="form-row">
            <div class="form-group">
              <?= $form->field($searchModel, 'nome')->textInput(['placeholder' => 'Nome do Banco'])->label('Nome') ?>
            </div>
            <div class="form-group">
              <?= $form->field($searchModel, 'descricao')->textInput(['placeholder' => 'Descrição'])->label('Descrição') ?>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="control-label"><?= Yii::t('app', 'Data de Início do Cartão') ?></label>
              <?= DatePicker::widget([
                'model' => $searchModel,
                'attribute' => 'data_inicio_cartao',
                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                'options' => ['placeholder' => 'Selecione a data de início'],
                'pluginOptions' => [
                  'autoclose' => true,
                  'todayHighlight' => true,
                  'format' => 'yyyy-mm-dd',
                ]
              ]); ?>
            </div>
            <div class="form-group">
              <label class="control-label"><?= Yii::t('app', 'Data de Fechamento do Cartão') ?></label>
              <?= DatePicker::widget([
                'model' => $searchModel,
                'attribute' => 'data_fechamento_cartao',
                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                'options' => ['placeholder' => 'Selecione a data de fim'],
                'pluginOptions' => [
                  'autoclose' => true,
                  'todayHighlight' => true,
                  'format' => 'yyyy-mm-dd',
                ]
              ]); ?>
            </div>
          </div>

          <div class="form-group text-center">
            <?= Html::submitButton('<i class="fa fa-filter"></i> ' . Yii::t('app', 'Filtrar'), ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('<i class="fa fa-eraser"></i> ' . Yii::t('app', 'Limpar'), ['class' => 'btn btn-default']) ?>
          </div>

          <?php ActiveForm::end(); ?>
        </div>
      </div>

      <!-- Rodapé do Modal (opcional) -->
      <div class="modal-footer">
        <!-- Botões adicionais podem ser adicionados aqui, se necessário -->
      </div>
    </div>
  </div>
</div>