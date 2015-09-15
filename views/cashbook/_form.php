<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Category;
use kartik\widgets\DatePicker;

?>

<?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

<div class="cashbook-form">

    <ul class="nav nav-tabs">
        <li class="active"><a href="#home" data-toggle="tab"><i class="fa fa-cube"></i> <?php echo Yii::t('app', 'Basic Information');?></a></li>
        <li><a href="#profile" data-toggle="tab"><i class="fa fa-cubes"></i> <?php echo Yii::t('app', 'Additional');?></a></li>
    </ul>
    <div class="tab-content">
    <div class="tab-pane active" id="home">

    <?= $form->field($model, 'type_id')->radioList([
        '1' => Yii::t('app', 'Revenue'), 
        '2' => Yii::t('app', 'Expense'),
        ], ['itemOptions' => ['class' =>'radio-inline','labelOptions'=>array('style'=>'padding:5px;')]])->label('') ?>

    <div class="row">
        <div class="col-sm-2">
        <?php
            echo DatePicker::widget([
                'model' => $model,
                'form' => $form,
                'attribute' => 'date',
                'type' => DatePicker::TYPE_INPUT,
                'size' => 'sm',
                'value' => '2015-01-30',
                //'readonly' => true,
                'options' => [
                    'placeholder' => '',
                ],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'todayHighlight' => true,
                    'format' => 'yyyy-mm-dd',
                ]
            ]);
        ?></div>
        </div>
    <p>
    <div class="row">
        <div class="col-sm-2">
        <?= $form->field($model, 'value')->textInput(['size' => 10]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
        <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->where(['user_id' => Yii::$app->user->identity->id])->orderBy("desc_category ASC")->all(), 'id_category', 'desc_category'),['prompt'=>'-- Selecione --'])  ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-5">
        <?= $form->field($model, 'description')->textInput(['maxlength' => 100]) ?>
        </div>
    </div>

    </div>
    <div class="tab-pane" id="profile">

    <?= $form->field($model, 'is_pending')->checkbox() ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save') : '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-primary grid-button btn-sm' : 'btn btn-primary grid-button btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
