<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var amnah\yii2\user\models\Profile $profile
 */

$this->title = Yii::t('user', 'Profile');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-default-profile">

	<h2><?= Html::encode($this->title) ?></h2>
    <hr/>

    <?php if ($flash = Yii::$app->session->getFlash("Profile-success")): ?>

        <div class="alert alert-success">
            <p><?= $flash ?></p>
        </div>

    <?php endif; ?>

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
        ]); 
    ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <?= Html::submitButton('<i class="fa fa-pencil-square-o"></i> '.Yii::t('user', 'Update'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>