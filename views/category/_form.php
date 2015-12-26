<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\color\ColorInput;

?>

<div class="category-form">

    <?php $form = ActiveForm::begin([
        'id' => 'categoryform',
        'options' => [
            'class' => 'form-horizontal',
            ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>


    <?= $form->field($model, 'desc_category')->textInput(['maxlength' => 45]) ?>

    <?php
    echo $form->field($model, 'hexcolor_category')->widget(ColorInput::classname(), [
    	'options' => ['placeholder' => Yii::t('app', 'Select')],
	]);
    ?>

    <?= $form->field($model, 'is_active')->radioList([
    '1' => Yii::t('app', 'Yes'), 
    '0' => Yii::t('app', 'No'),
    ], ['itemOptions' => ['class' =>'radio-inline','labelOptions'=>array('style'=>'padding:5px;')]]) ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save') : '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-primary grid-button' : 'btn btn-primary grid-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
