<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = Yii::t('app', 'Entry') . " #" . $model->id;
?>
<div class="cashbook-view">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="ml-auto button-group">
            <?= Html::a(
                '<i class="fa fa-pencil-square-o"></i> ' . Yii::t('app', 'Update'),
                ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary btn-hover']
            ) ?>
            <?= Html::a(
                '<i class="fa fa-clone"></i> ' . Yii::t('app', 'Clone'),
                ['clone', 'id' => $model->id],
                ['class' => 'btn btn-primary btn-hover']
            ) ?>
            <?= Html::a(
                '<i class="glyphicon glyphicon-trash"></i> ' . Yii::t('app', 'Delete'),
                ['delete', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger btn-hover',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete?'),
                        'method' => 'post',
                    ],
                ]
            ) ?>
        </div>
    </div>

    <!-- Alerts -->
    <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
        <?php $alertClass = substr($key, strpos($key, '-') + 1); ?>
        <div class="alert alert-dismissible alert-<?= $alertClass ?>" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <p><?= $message ?></p>
        </div>
    <?php endforeach ?>

    <div class="card">
        <div class="card-body">
            <h2 class="m-0 mx-auto text-center title"><?= Html::encode($this->title) ?></h2>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'value',
                        'format' => 'raw',
                        'value' => $model->type_id == 1
                            ? '<span class="label label-success">' . Yii::t('app', '$') . " " . $model->value . '</span>'
                            : '<span class="label label-danger">' . Yii::t('app', '$') . " " . $model->value . '</span>',
                    ],
                    [
                        'attribute' => 'category_id',
                        'value' => $model->category->desc_category,
                    ],
                    [
                        'attribute' => 'date',
                        'format' => ['date', 'd/M/Y'],
                    ],
                    'description',
                    [
                        'attribute' => 'is_pending',
                        'format' => 'raw',
                        'value' => $model->is_pending == 1
                            ? '<span class="label label-warning">' . Yii::t('app', 'Yes') . '</span>'
                            : Yii::t('app', 'No'),
                    ],
                    [
                        'attribute' => 'attachment',
                        'format' => 'raw',
                        'value' => $model->attachment == null
                            ? Yii::t('app', 'No attachment')
                            : '<span class="glyphicon glyphicon-paperclip"></span> ' . Html::a(Yii::t('app', 'Attach'), Yii::$app->request->baseUrl . "/uploads/" . $model->user_id . "/" . $model->attachment, ['target' => '_blank']),
                    ],
                    [
                        'attribute' => 'inc_datetime',
                        'value' => Yii::$app->formatter->asDate($model->inc_datetime, 'long'),
                    ],
                    [
                        'attribute' => 'edit_datetime',
                        'value' => Yii::$app->formatter->asDate($model->edit_datetime, 'long'),
                    ],
                ],
                'options' => ['class' => 'table table-bordered'],
            ]) ?>
        </div>
    </div>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        /* Muda a fonte padrão para uma mais moderna */
        background-color: #f8f9fa;
        /* Cor de fundo suave */
    }

    .btn-hover {
        transition: background-color 0.3s ease, transform 0.3s ease;
        font-size: 1.7rem;
        /* Aumenta o tamanho da fonte dos botões */
    }

    .btn-hover:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .card {
        border: 1px solid #007bff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
        background-color: #ffffff;
        /* Fundo branco para o cartão */
    }

    .card-body {
        padding: 20px;
        font-size: 2rem;
        /* Tamanho da fonte no corpo do cartão */
    }

    .title {
        font-weight: bold;
        color: #007bff;
        font-size: 3rem;
        /* Tamanho do título */
        text-align: center;
        /* Alinha o texto ao centro */
        margin-bottom: 20px;
        /* Espaço abaixo do título */
    }

    .button-group {
        display: flex;
        gap: 10px;
        /* Espaçamento entre os botões */
    }

    .alert {
        margin-bottom: 20px;
        font-size: 1.1rem;
        /* Tamanho da fonte nas mensagens de alerta */
    }

    .detail-view td {
        font-size: 1.2rem;
        /* Tamanho da fonte das células do DetailView */
    }

    .detail-view th {
        font-size: 1.2rem;
        /* Tamanho da fonte dos cabeçalhos do DetailView */
        background-color: #f1f1f1;
        /* Fundo para os cabeçalhos */
    }

    /* Cores para as labels */
    .label-success {
        background-color: #d4edda;
        /* Verde claro para sucesso */
        color: #155724;
        /* Texto verde escuro */
    }

    .label-danger {
        background-color: #f8d7da;
        /* Vermelho claro para erro */
        color: #721c24;
        /* Texto vermelho escuro */
    }

    .label-warning {
        background-color: #fff3cd;
        /* Amarelo claro para aviso */
        color: #856404;
        /* Texto amarelo escuro */
    }

    h2 {
        margin: 0;
        /* Remove margens do h2 */
    }
</style>