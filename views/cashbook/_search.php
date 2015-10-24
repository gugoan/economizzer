<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Category;
use app\models\Type;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\CashbookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cashbook-search">

    <?php $form = ActiveForm::begin([
        //'options' => ['class' => 'form-horizontal'],
        //'fieldConfig' => [
        //    'template' => "{label}\n<div class=\"col-lg-8\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
        //    'labelOptions' => ['class' => 'col-lg-4 control-label'],
        //    ],
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-11">
            <?php
                echo '<label class="control-label">'.Yii::t('app', 'From').'</label>';
                echo DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'start_date',
                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                    //'size' => 'sm',
                    //'value' => '2015-01-30',
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
            ?>
        </div>
    </div><p>
    <div class="row">
        <div class="col-sm-11">
        <?php
            echo '<label class="control-label">'.Yii::t('app', 'To').'</label>';
            echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'end_date',
                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                //'size' => 'sm',
                //'value' => '2015-01-30',
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
        ?>
        </div>
    </div><p>

    <?= $form->field($model, 'type_id')->dropDownList(
        [
            '1' => Yii::t('app', 'Revenue'),
            '2' => Yii::t('app', 'Expense'),
        ],
        [
            'prompt'=>Yii::t('app', 'All')
        ]);//->dropDownList(ArrayHelper::map(Type::find()->all(), 'id_type', 'desc_type'),['prompt'=>Yii::t('app', 'All')])  ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->where(['user_id' => Yii::$app->user->identity->id])->orderBy("desc_category ASC")->all(), 'id_category', 'desc_category'),['prompt'=>Yii::t('app', 'All')])  ?>

    <?= $form->field($model, 'account_id')->dropDownList(ArrayHelper::map(\app\models\Account::find()->where(['user_id' => Yii::$app->user->identity->id])->orderBy("description ASC")->all(), 'id', 'description'),['prompt'=>Yii::t('app', 'All')])  ?>

    <?= $form->field($model, 'value') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'is_pending')->checkbox() ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'is_pending') ?>

    <?php // echo $form->field($model, 'attachment') ?>

    <?php // echo $form->field($model, 'inc_datetime') ?>

    <?php // echo $form->field($model, 'edit_datetime') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '<i class="fa fa-filter"></i> Filter'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', '<i class="fa fa-eraser"></i> Clean'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
