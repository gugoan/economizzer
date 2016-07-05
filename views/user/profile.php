<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('user', 'Profile');
?>
<div class="user-default-profile">

	<h2><?= Html::encode($this->title) ?></h2>
    <hr/>

    <?php foreach (Yii::$app->session->getAllFlashes() as $key=>$message):?>
        <?php $alertClass = substr($key,strpos($key,'-')+1); ?>
        <div class="alert alert-dismissible alert-<?=$alertClass?>" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p><?=$message?></p>
        </div>
    <?php endforeach ?> 

    <?php $form = ActiveForm::begin([
        'id' => 'profile-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
        'enableAjaxValidation' => true,
    ]); ?>

    <?= $form->field($profile, 'full_name') ?>

    <?php echo $form->field($profile, 'language')->dropDownList([
        'en' => Yii::t('app', 'English USA'), 
        'pt' => Yii::t('app', 'Brazilian Portuguese'), 
        'ru' => Yii::t('app', 'Russian'), 
        'ko' => Yii::t('app', 'Korean'), 
        'hu' => Yii::t('app', 'Magyar'),
        'fr' => Yii::t('app', 'French'),
        ]); 
    ?>

    <?php echo $form->field($profile, 'startpage')->dropDownList([
        'cashbook/index' => Yii::t('app', 'Entries Page'), 
        'dashboard/overview' => Yii::t('app', 'Dashboard Page'), 
        ]); 
    ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <?= Html::submitButton('<i class="fa fa-pencil-square-o"></i> '.Yii::t('user', 'Update'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
