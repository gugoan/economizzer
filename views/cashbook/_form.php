<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Cashbook */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cashbook-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->textInput() ?>

    <?= $form->field($model, 'type_id')->textInput() ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'is_pending')->textInput() ?>

    <?= $form->field($model, 'attachment')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'inc_datetime')->textInput() ?>

    <?= $form->field($model, 'edit_datetime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
