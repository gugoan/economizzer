<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Category;
use kartik\widgets\DatePicker;
use kartik\number\NumberControl;

?>

<div class="cashbook-form">

    <div class="title">Novo Lançamento</div>

    <?php $form = ActiveForm::begin([
        'id' => 'cashbookform',
        'options' => [
            'enctype' => 'multipart/form-data',
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-8\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <h4><i class="fa fa-info-circle"></i> Informações Básicas</h4>
            <div class="row">
                <?php
                echo $form->field($model, 'type_id')->radioList([
                    '1' => Yii::t('app', 'Receita'),
                    '2' => Yii::t('app', 'Despesa'),
                ], ['itemOptions' => ['class' => 'radio-inline']])->label('Tipo:');
                ?>
            </div>

            <?= $form->field($model, 'date')->textInput(['type' => 'date']) ?>

            <?= $form->field($model, 'value')->widget(NumberControl::classname()); ?>

            <?= $form->field($model, 'category_id', [
                'inputOptions' => [
                    'class' => 'selectpicker'
                ]
            ])->dropDownList(app\models\Category::getHierarchy(), ['prompt' => Yii::t('app', 'Selecionar'), 'class' => 'form-control required']); ?>

            <?= $form->field($model, 'description')->textInput(['maxlength' => 100]) ?>
        </div>

        <div class="col-md-6">
            <h4><i class="fa fa-plus-circle"></i> Informações Complementares</h4>
            <?= $form->field($model, 'is_pending')->checkbox([
                'label' => '',
                'labelOptions' => array('class' => 'control-label'),
            ])->label(Yii::t('app', 'Pendente')) ?>

            <div class="form-group text-center mb-4">
                <label for="file-upload" class="btn btn-outline-primary"
                    style="display: inline-block; padding: 10px 20px; font-size: 1.1em; border-radius: 5px; cursor: pointer; background-color: #e7f3ff; color: #2c3e50;">
                    <i class="fa fa-file-pdf-o"></i> Escolher arquivo PDF
                </label>
                <?= $form->field($model, 'file')->fileInput(['id' => 'file-upload', 'accept' => 'application/pdf', 'style' => 'display:none;'])->label(false) ?>
            </div>
        </div>
    </div>

    <div class="form-group text-center" style="position: sticky; bottom: 0; background-color: #ffffff; padding: 10px;">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> ' . Yii::t('app', 'Salvar') : '<i class="fa fa-floppy-o"></i> ' . Yii::t('app', 'Salvar'), ['class' => 'btn btn-custom']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<style>
    .cashbook-form {
        padding: 30px;
        border-radius: 10px;
        background-color: #ffffff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin: 20px;
    }

    .form-control,
    .selectpicker {
        border-radius: 5px;
        border: 1px solid #ced4da;
        transition: border-color 0.3s, box-shadow 0.3s;
        height: 45px;
    }

    .form-control:focus,
    .selectpicker:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .form-control:hover,
    .selectpicker:hover {
        border-color: #007bff;
    }

    .radio-inline {
        margin-right: 15px;
        font-weight: 500;
    }

    .btn-custom {
        transition: all 0.3s ease;
        border-radius: 5px;
        background-color: #007bff;
        color: white;
    }

    .btn-custom:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .nav-tabs>li>a {
        color: #007bff;
        font-weight: bold;
    }

    .nav-tabs>li.active>a {
        background-color: #e9ecef;
        border: 1px solid #007bff;
        color: #007bff;
    }

    .nav-tabs>li>a:hover {
        background-color: #e9ecef;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .title {
        text-align: center;
        font-size: 2em;
        font-weight: bold;
        margin-bottom: 30px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Atualiza o nome do arquivo no botão após a seleção
        document.getElementById('file-upload').addEventListener('change', function() {
            var fileName = this.files[0] ? this.files[0].name : 'Escolher arquivo PDF';
            document.querySelector('label[for="file-upload"]').innerHTML = '<i class="fa fa-file-pdf-o"></i> ' +
                fileName;
        });
    });
</script>