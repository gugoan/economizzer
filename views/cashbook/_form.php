<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Category;
use kartik\widgets\DatePicker;

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
            // 'readonly' => true,
            // 'options' => [
            //     'placeholder' => '',
            // ],
            'pluginOptions' => [
                'autoclose'=>true,
                'todayHighlight' => true,
                'format' => 'yyyy-mm-dd',
            ]
        ]);
    ?>
    
    <?= $form->field($model, 'value')->textInput(['size' => 10]) ?>

    <?php // echo $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->where(['user_id' => Yii::$app->user->identity->id, 'is_active' => 1])->orderBy("desc_category ASC")->all(), 'id_category', 'desc_category'),['prompt'=>Yii::t('app','Select')])  ?>

    <?=
    $form->field($model, 'category_id', [
        'inputOptions' => [
            'class' => 'selectpicker '
        ]
    ]
    )->dropDownList(app\models\Category::getHierarchy(), ['prompt' => 'Selecione', 'class'=>'form-control required']);
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
<div class="panel panel-warning">
      <div class="panel-body">
<div class="alert alert-warning" role="alert"><h4><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> <?php echo Yii::t('app', 'Attention');?></h4></div>
<p><?php echo Yii::t('app', 'After the last update on January 3, 2016, the categories were separated hierarchically, with only the sub-categories will be selectable.');?></p>
<p><?php echo Yii::t('app', 'So we need to organize your category structure, creating parent-categories and assign it subcategories.');?></p>
<p><?php echo Yii::t('app', 'To start do the following: Create the GENERAL category, and assign all other categories as daughters of the GENERAL category. After that separates the way that suits you best.');?></p>
<p><?php echo Yii::t('app', 'This will help you get a higher level of detail of the entries.');?></p>
      </div>
    </div>
</div>
</div>
