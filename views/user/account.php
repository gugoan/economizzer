<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var amnah\yii2\user\models\User $user
 */

$this->title = Yii::t('user', 'Account');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-default-account">
    <div class="row">
        <div class="col-sm-9">
            <h2>
                <span><?= Html::encode($this->title) ?></span>
            </h2>
            <hr/>

            <?php if ($flash = Yii::$app->session->getFlash("Account-success")): ?>

                <div class="alert alert-success">
                    <p><?= $flash ?></p>
                </div>

            <?php elseif ($flash = Yii::$app->session->getFlash("Resend-success")): ?>

                <div class="alert alert-success">
                    <p><?= $flash ?></p>
                </div>

            <?php elseif ($flash = Yii::$app->session->getFlash("Cancel-success")): ?>

                <div class="alert alert-success">
                    <p><?= $flash ?></p>
                </div>

            <?php endif; ?>

            <?php $form = ActiveForm::begin([
                'id' => 'account-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-2 control-label'],
                ],
                'enableAjaxValidation' => true,
            ]); ?>

            <?= $form->field($user, 'currentPassword')->passwordInput() ?>

            <hr/>

            <?php if (Yii::$app->getModule("user")->useEmail): ?>
                <?= $form->field($user, 'email') ?>
            <?php endif; ?>

            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">

                    <?php if ($user->new_email !== null): ?>

                        <p class="small"><?= Yii::t('user', "Pending email confirmation: [ {newEmail} ]", ["newEmail" => $user->new_email]) ?></p>
                        <p class="small">
                            <?= Html::a(Yii::t("user", "Resend"), ["/user/resend-change"]) ?> <?=Yii::t("user", "or") ?> <?= Html::a(Yii::t("user", "Cancel"), ["/user/cancel"]) ?>
                        </p>

                    <?php elseif (Yii::$app->getModule("user")->emailConfirmation): ?>

                        <p class="small"><?= Yii::t('user', 'Changing your email requires email confirmation') ?></p>

                    <?php endif; ?>

                </div>
            </div>

            <?php if (Yii::$app->getModule("user")->useUsername): ?>
                <?= $form->field($user, 'username') ?>
            <?php endif; ?>

            <?= $form->field($user, 'newPassword')->passwordInput() ?>

            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <?= Html::submitButton(Yii::t('user', 'Update'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?=Yii::t('user','Linked accounts')?></h3>
                </div>
                <div class="panel-body">
                    <?= yii\authclient\widgets\AuthChoice::widget([
                        'baseAuthUrl' => ['/user/auth/connect']
                    ]) ?>
                </div>
            </div>
        </div>
    </div>


</div>