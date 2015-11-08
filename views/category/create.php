<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Create category', [
    'modelClass' => 'Category',
]);
?>
<div class="category-create">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr/>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
