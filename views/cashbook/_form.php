<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Category;
use kartik\widgets\DatePicker;
use kartik\money\MaskMoney;

?>

<div class="cashbook-form">

<div class="col-md-8">
    <?php $form = ActiveForm::begin([
        'id' => 'cashbookform',
        'options' => [
            'enctype'=>'multipart/form-data',
            'class' => 'form-horizontal',
            ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#home" data-toggle="tab"><i class="fa fa-cube"></i> <?php echo Yii::t('app', 'Basic Information');?></a></li>
        <li><a href="#profile" data-toggle="tab"><i class="fa fa-cubes"></i> <?php echo Yii::t('app', 'Additional');?></a></li>
    </ul>
    <div class="tab-content">
    <div class="tab-pane active" id="home">
    <p>
    <?php 
    echo $form->field($model, 'type_id')->radioList([
        '1' => Yii::t('app', 'Revenue'), 
        '2' => Yii::t('app', 'Expense'),
        ], ['itemOptions' => ['class' =>'radio-inline','labelOptions'=>array('style'=>'padding:4px;')]])->label('');
    ?>

    <?php
        echo DatePicker::widget([
            'model' => $model,
            'form' => $form,
            'attribute' => 'date',
            'type' => DatePicker::TYPE_INPUT,
            'size' => 'sm',
            'pluginOptions' => [
                'autoclose'=>true,
                'todayHighlight' => true,
                'format' => 'yyyy-mm-dd',
            ]
        ]);
    ?>
    
    <?php 
    echo $form->field($model, 'value')->widget(MaskMoney::classname(), [
        'pluginOptions' => [
            //'prefix' => 'R$ ',
            //'suffix' => ' c',
            'affixesStay' => true,
            //'thousands' => '.',
            //'decimal' => ',',
            'precision' => 2, 
            'allowZero' => true,
            'allowNegative' => true,
            //'value' => 0.01
        ],
    ]); 
    ?>

    <?=
    $form->field($model, 'category_id', [
        'inputOptions' => [
            'class' => 'selectpicker '
        ]
    ]
    )->dropDownList(app\models\Category::getHierarchy(), ['prompt' => Yii::t('app', 'Select'), 'class'=>'form-control required']);
    ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 100]) ?>

    </div>
    <div class="tab-pane" id="profile">

    <?= $form->field($model, 'is_pending')->checkbox([
        'label' => '',
        'labelOptions'=>array('class'=>'col-lg-2 control-label'),
        ])->label(Yii::t('app', 'Pending')) ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save') : '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-primary grid-button' : 'btn btn-primary grid-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<div class="col-md-4">
<!-- ADS test -->
</div>
</div>
