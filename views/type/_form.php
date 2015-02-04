<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\color\ColorInput;

/* @var $this yii\web\View */
/* @var $model app\models\Type */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="type-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-2">
    	<?= $form->field($model, 'desc_type')->textInput(['maxlength' => 45]) ?>
    	</div>
    </div>
    <div class="row">
        <div class="col-sm-2">
	    <?php
	    //$form->field($model, 'hexcolor_type')->textInput(['maxlength' => 45]) 
	    echo $form->field($model, 'hexcolor_type')->widget(ColorInput::classname(), [
	    	'options' => ['placeholder' => 'Selecione'],
		]);
	    ?>
	    </div>
    </div>

    <?php // $form->field($model, 'icon_type')->textInput(['maxlength' => 45]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', '<i class="fa fa-floppy-o"></i> Gravar') : Yii::t('app', '<i class="fa fa-floppy-o"></i> Gravar'), ['class' => $model->isNewRecord ? 'btn btn-primary grid-button btn-sm' : 'btn btn-primary grid-button btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
