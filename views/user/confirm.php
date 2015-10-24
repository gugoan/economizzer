<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var bool $success
 */

$this->title = Yii::t('user', $success ? 'Confirmed' : 'Error');
?>
<div class="user-default-confirm">

    <?php if ($success): ?>

        <div class="alert alert-success">

            <p><?= Yii::t("user", "Your email [ {email} ] has been confirmed", ["email" => $success]) ?></p>

            <?php if (Yii::$app->user->isLoggedIn): ?>

                <p><?= Html::a(Yii::t("user", "Go to my account"), ["/user/account"]) ?></p>
                <p><?= Html::a(Yii::t("user", "Go home"), Yii::$app->getHomeUrl()) ?></p>

            <?php else: ?>

                <p><?= Html::a(Yii::t("user", "Log in here"), ["/user/login"]) ?></p>

            <?php endif; ?>

        </div>


    <?php else: ?>

        <div class="alert alert-danger"><?= Yii::t("user", "Invalid key") ?></div>

    <?php endif; ?>

</div>