<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Button;

$this->title = Yii::t('app', 'Account');
?>
<div class="user-default-account">
    <h2>
        <span><?= Html::encode($this->title) ?></span>
    </h2>
    <hr/>
    <!-- Alerts -->
    <?php foreach (Yii::$app->session->getAllFlashes() as $key=>$message):?>
        <?php $alertClass = substr($key,strpos($key,'-')+1); ?>
        <div class="alert alert-dismissible alert-<?=$alertClass?>" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p><?=$message?></p>
        </div>
    <?php endforeach ?>

    <?php $form = ActiveForm::begin([
        'id' => 'account-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
        'enableAjaxValidation' => true,
    ]); ?>
    <?php if ($user->scenario == 'account'):?>
        <?= $form->field($user, 'currentPassword')->passwordInput() ?>
        <hr/>
    <?php endif; ?>



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

    <?php if ($user->scenario == 'socialonlyaccount'):?>
        <?= $form->field($user, 'newPasswordConfirm')->passwordInput() ?>
    <?php endif;?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <?= Html::submitButton('<i class="fa fa-pencil-square-o"></i> '.Yii::t('user', 'Update'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <hr/>

    <div class="keychain">
        <h3><?=Yii::t('user', 'Keychain')?></h3>
        <div class="keychain-connected">
            <?php foreach($keychainConnects as $keychainConnect):?>
                <div class="row service">
                    <div class="col-sm-12">
                        <div class="fields-title">
                            <?=ucfirst($keychainConnect['provider'])?> <span class="label label-success"><?=Yii::t('user','Connected')?></span>
                        </div>
                    </div>
                    <div class="col-sm-9"><?=Html::a(Html::img($keychainConnect['imageUrl']), $keychainConnect['url'])?> <?=$keychainConnect['displayName']?></div>
                    <div class="col-sm-3">

                        <div class="fields-btn">
                            <?= Html::a(Yii::t('user','Disconnect'), ['/user/auth/disconnect', 'id'=>$keychainConnect['id']], ['class' => 'btn btn-sm btn-danger'])?>
                        </div>
                    </div>
                </div>
                <hr/>
            <?php endforeach;?>
        </div>
        <div class="keychain-bind">
            <h4><?=Yii::t('user', 'Bind account')?></h4>
            <div class="keychain-bind-description">
                <?=Yii::t('user', 'Linking social network accounts (can be several) to your account will allow you to enter in a single click.')?>
            </div>
        </div>
    </div>
    <?= app\widgets\authchoice\AuthChoice::widget([
        'baseAuthUrl' => ['/user/auth/connect'],
        'keychainConnects' => $keychainConnects
    ]) ?>

</div>