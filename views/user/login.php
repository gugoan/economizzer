<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\models\LoginForm $model
 */

?>
<div class="user-default-login">
	<div class="container">
		<div class="row">
		<div class="col-sm-6 col-md-4 col-md-offset-4">
		<h1 class="text-center login-title"><?php echo Yii::t("user", "Login to access the System");?></h1>
		<div class="account-wall">
		<img class="profile-img" src="images/logo-profile.png" alt="">
			<?php $form = ActiveForm::begin([
				'id' => 'login-form',
				'options' => ['class' => 'form-signin'],
				'fieldConfig' => [
					//'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
					//'labelOptions' => ['class' => 'col-lg-2 control-label'],
				],

			]); ?>

			<?= $form->field($model, 'username') ?>
			<?= $form->field($model, 'password')->passwordInput() ?>
			<?= $form->field($model, 'rememberMe', [
				'template' => "{label}<div class=\"checkbox pull-left\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
			])->checkbox() ?>

					<?= Html::submitButton(Yii::t('user', 'Login'), ['class' => 'btn btn-lg btn-primary btn-block']) ?>
		            <?= Html::a(Yii::t("user", "Forgot password") . "?", ["/user/forgot"], array('class' => 'text-center new-account')) ?>

			<?php ActiveForm::end(); ?>

		    <?php if (Yii::$app->get("authClientCollection", false)): ?>
		        <div class="col-lg-offset-2">
		            <?= yii\authclient\widgets\AuthChoice::widget([
		                'baseAuthUrl' => ['/user/auth/login']
		            ]) ?>
		        </div>
		    <?php endif; ?>
		</div>
		</div>
		</div>
	</div> 
</div>