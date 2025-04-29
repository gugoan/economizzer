<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="target-form">

  <div class="col-md-8">
    <?php $form = ActiveForm::begin([
      'id' => 'targetform',
      'options' => [
        'enctype' => 'multipart/form-data',
        'class' => 'form-horizontal',
      ],
      'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-2 control-label'],
      ],
    ]); ?>

    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab"><i class="fa fa-flag"></i>
          <?= Yii::t('app', 'Goal Information'); ?></a></li>
      <li><a href="#profile" data-toggle="tab"><i class="fa fa-info"></i>
          <?= Yii::t('app', 'Additional Details'); ?></a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="home">
        <p>
          <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'due_date')->textInput(['type' => 'date']) ?>

          <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>

          <?= $form->field($model, 'target_value')->textInput(['type' => 'number', 'step' => '0.01']) ?>

        </p>
      </div>
      <div class="tab-pane" id="profile">
        <?= $form->field($model, 'is_completed')->checkbox(['label' => '', 'labelOptions' => ['class' => 'col-lg-2 control-label']])->label(Yii::t('app', 'Completed')) ?>

        <?= $form->field($model, 'file')->fileInput() ?>
      </div>
    </div>

    <div class="form-group">
      <div class="col-lg-offset-2 col-lg-10">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> ' . Yii::t('app', 'Save') : '<i class="fa fa-floppy-o"></i> ' . Yii::t('app', 'Update'), ['class' => 'btn btn-primary grid-button']) ?>
      </div>
    </div>

    <?php ActiveForm::end(); ?>
    <?php if ($model->hasErrors()): ?>
      <pre><?= print_r($model->errors, true); ?></pre>
    <?php endif; ?>

  </div>
  <div class="col-md-4">
    <!-- ADS test -->
  </div>
</div>