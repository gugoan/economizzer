<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = Yii::t('app', 'Update', [
    'modelClass' => 'Category',
]) . ' ' . $model->desc_category;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->desc_category, 'url' => ['view', 'id' => $model->id_category]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="category-update">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr/>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
