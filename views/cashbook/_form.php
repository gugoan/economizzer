<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Cashbook */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cashbook-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type_id')->radioList(['1' => 'Receita', '2' => 'Despesa'], ['itemOptions' => ['class' =>'radio-inline']]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->orderBy("desc_category ASC")->all(), 'id_category', 'desc_category'),['prompt'=>'-- Selecione --'])  ?>

    <?= $form->field($model, 'type_id')->textInput() ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'is_pending')->textInput() ?>

    <?= $form->field($model, 'attachment')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
