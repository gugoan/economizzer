<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Dashboard */

$this->title = Yii::t('app', 'Create Dashboard');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dashboards'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dashboard-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
