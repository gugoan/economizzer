<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Category;
use app\models\Type;

/* @var $this yii\web\View */
/* @var $model app\models\CashbookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cashbook-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'type_id')->dropDownList(ArrayHelper::map(Type::find()->all(), 'id_type', 'desc_type'),['prompt'=>'-- Selecione --'])  ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->orderBy("desc_category ASC")->all(), 'id_category', 'desc_category'),['prompt'=>'-- Selecione --'])  ?>

    <?= $form->field($model, 'value') ?>

    <?= $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'is_pending') ?>

    <?php // echo $form->field($model, 'attachment') ?>

    <?php // echo $form->field($model, 'inc_datetime') ?>

    <?php // echo $form->field($model, 'edit_datetime') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Filtrar'), ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::resetButton(Yii::t('app', 'Limpar'), ['class' => 'btn btn-default btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
