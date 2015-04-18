<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Category;
use kartik\widgets\DatePicker;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Cashbook */
/* @var $form yii\widgets\ActiveForm */
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
            echo Html::activeLabel($model,'date'); //label
            echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'date',
                'type' => DatePicker::TYPE_INPUT,
                'size' => 'sm',
                'value' => '2015-01-30',
                //'readonly' => true,
                'options' => [
                    'placeholder' => '',
                     'class'=>'form-control',
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

    <?php // $form->field($model, 'file')->fileInput() 
    // try:
    // http://webtips.krajee.com/advanced-upload-using-yii2-fileinput-widget/
    // http://webtips.krajee.com/upload-file-yii-2-using-fileinput-widget/
    // echo '<label class="control-label">Anexos</label>';
    // echo FileInput::widget([
    //     'model' => $model,
    //     'attribute' => 'file',
    //     'options' => ['multiple' => false],
    //     'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png','pdf']],
    // ]);
    $title = isset($model->filename) && !empty($model->filename) ? $model->filename : 'Anexo';
    echo Html::img($model->getImageUrl(), [
        'class'=>'img-thumbnail',
        'alt'=>$title,
        'title'=>$title
    ]);

    if (!$model->isNewRecord) {
    echo Html::a('Delete', ['/Cashbook/delete', 'id'=>$model->id], ['class'=>'btn btn-danger']);
}

    echo $form->field($model, 'file')->widget(FileInput::classname(), [
        //'options'=>['accept'=>'image/*'],
        'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png', 'pdf']
    ]]);
    ?>

    </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', '<i class="fa fa-floppy-o"></i> Save') : Yii::t('app', '<i class="fa fa-floppy-o"></i> Save'), ['class' => $model->isNewRecord ? 'btn btn-primary grid-button btn-sm' : 'btn btn-primary grid-button btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
