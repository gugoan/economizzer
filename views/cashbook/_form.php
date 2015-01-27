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

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

        <div class="cashbook-form">

    <ul class="nav nav-tabs">
        <li class="active"><a href="#home" data-toggle="tab"><i class="fa fa-cube"></i> Informações Básicas</a></li>
        <li><a href="#profile" data-toggle="tab"><i class="fa fa-cubes"></i> Avançadas</a></li>
    </ul>
    <div class="tab-content">
    <div class="tab-pane active" id="home">

    <?= $form->field($model, 'type_id')->radioList([
        '1' => 'Receita', 
        '2' => 'Despesa'
        ], ['itemOptions' => ['class' =>'radio-inline','labelOptions'=>array('style'=>'padding:5px;')]])->label('') ?>

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
                        ])
    ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->orderBy("desc_category ASC")->all(), 'id_category', 'desc_category'),['prompt'=>'-- Selecione --'])  ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 45]) ?>

    </div>
    <div class="tab-pane" id="profile">

    <?= $form->field($model, 'is_pending')->checkbox() ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', '<i class="fa fa-floppy-o"></i> Gravar') : Yii::t('app', '<i class="fa fa-floppy-o"></i> Gravar'), ['class' => $model->isNewRecord ? 'btn btn-primary grid-button btn-sm' : 'btn btn-primary grid-button btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
