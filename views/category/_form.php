<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\color\ColorInput;

?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
    	<div class="col-sm-3">
    		<?= $form->field($model, 'desc_category')->textInput(['maxlength' => 45]) ?>
    	</div>
    </div>
    <div class="row">
        <div class="col-sm-2">
		    <?php
		    echo $form->field($model, 'hexcolor_category')->widget(ColorInput::classname(), [
		    	'options' => ['placeholder' => Yii::t('app', 'Select')],
			]);
		    ?>
	    </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save') : '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-primary grid-button' : 'btn btn-primary grid-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
