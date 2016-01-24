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
<div class="panel panel-success">
      <div class="panel-body">
<div class="alert alert-success" role="alert"><h4><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> <?php echo Yii::t('app', 'Follow us');?></h4></div>
<p><?php echo Yii::t('app', 'Support the Save and stay on top of updates, follow us and share with your friends');?></p>
<p><a href="https://twitter.com/economizzer" target="_blank"><img src="<?php echo Yii::$app->request->baseUrl;?>/images/follow-twitter.png" align="absbottom"></a></p>
<p><a href="https://www.facebook.com/economizzer" target="_blank"><img src="<?php echo Yii::$app->request->baseUrl;?>/images/follow-facebook.png" align="absbottom"></a></p>
<p><a href="https://plus.google.com/101075084400357449168" target="_blank"><img src="<?php echo Yii::$app->request->baseUrl;?>/images/follow-googleplus.png" align="absbottom"></a></p>
      </div>
    </div>
</div>
</div>
