<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Currency */

$this->title = Yii::t('app', 'Create Currency');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Currencies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currency-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
