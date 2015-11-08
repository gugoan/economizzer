<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('user', 'Resend');
?>
<div class="user-default-resend">

	<h2><?= Html::encode($this->title) ?></h2>
    <hr/>
	<?php if ($flash = Yii::$app->session->getFlash('Resend-success')): ?>

        <div class="alert alert-success">
            <p><?= $flash ?></p>
        </div>

	<?php else: ?>

        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'resend-form']); ?>
                    <?= $form->field($model, 'email') ?>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('user', 'Submit'), ['class' => 'btn btn-primary']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

	<?php endif; ?>

</div>