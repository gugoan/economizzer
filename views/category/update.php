<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Update', [
    'modelClass' => 'Category',
]) . ' ' . $model->desc_category;
?>
<div class="category-update">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr/>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
