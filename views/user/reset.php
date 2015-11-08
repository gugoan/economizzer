<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('user', 'Reset');
?>
<div class="user-default-reset">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr/>

    <?php if (!empty($success)): ?>

        <div class="alert alert-success">

            <p><?= Yii::t("user", "Password has been reset") ?></p>
            <p><?= Html::a(Yii::t("user", "Log in here"), ["/user/login"]) ?></p>

        </div>

    <?php elseif (!empty($invalidKey)): ?>

        <div class="alert alert-danger">
            <p><?= Yii::t("user", "Invalid key") ?></p>
        </div>

	<?php else: ?>

        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'reset-form']); ?>

                    <?= $form->field($user, 'newPassword')->passwordInput() ?>
                    <?= $form->field($user, 'newPasswordConfirm')->passwordInput() ?>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t("user", "Reset"), ['class' => 'btn btn-primary']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

	<?php endif; ?>

</div>