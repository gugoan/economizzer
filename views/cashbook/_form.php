<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Category;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Cashbook */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cashbook-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'type_id')->radioList(['1' => 'Receita', '2' => 'Despesa'], ['itemOptions' => ['class' =>'radio-inline']]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->orderBy("desc_category ASC")->all(), 'id_category', 'desc_category'),['prompt'=>'-- Selecione --'])  ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'date')->widget(DatePicker::className(),
                    [
                        'language' => 'pt-BR',
                        //'dateFormat' => 'php:d/m/Y',
                        'dateFormat' => 'php:Y-m-d',
                        'clientOptions' =>[
                            //'defaultDate' => '2015-01-01',
                            //'country' => 'BR',
                            //'showAnim'=>'fold',
                            //'yearRange' => 'c-25:c+0',
                            //'changeMonth'=> false,
                            //'changeYear'=> false,
                            //'autoSize'=>true,
                            //'showOn'=> "button",
                            //'buttonImage'=> "images/calendar.gif",
                            ],
                        'options'=>[
                            'class' => 'form-control input-sm',
                            //'style'=>'width:80px;',
                            //'font-weight'=>'x-small',
                            ],
                            // list params: http://api.jqueryui.com/datepicker/
                        ]) ?> 

    <?= $form->field($model, 'is_pending')->checkbox() ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
