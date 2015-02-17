<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\color\ColorInput;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
    	<div class="col-sm-2">
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
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
