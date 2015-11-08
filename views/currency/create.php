<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Create Currency');
?>
<div class="currency-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
