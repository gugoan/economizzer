<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Account */

$this->title = Yii::t('app', 'Create Account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-create">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr/>

    <?= $this->render('_form', [
        'model' => $model,
        'currencyItems' => $currencyItems,
    ]) ?>

</div>
