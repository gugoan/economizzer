<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('app', 'Categories');
?>

<div class="category-index">

    <h2 style="text-align: center;">
        <span><?= Html::encode($this->title) ?></span>
        <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Create'), ['/category/create'], ['class' => 'btn btn-primary grid-button pull-right']) ?>
    </h2>
    <hr />

    <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
        <?php $alertClass = substr($key, strpos($key, '-') + 1); ?>
        <div class="alert alert-dismissible alert-<?= $alertClass ?>" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <p><?= $message ?></p>
        </div>
    <?php endforeach ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-hover'],
        'summary' => '',
        'rowOptions' => function ($model, $index, $widget, $grid) {
            return [
                'id' => $model['id_category'],
                'onclick' => 'location.href="' . Yii::$app->urlManager->createUrl('category/') . '/"+(this.id);',
                'style' => "cursor: pointer",
            ];
        },
        'columns' => [
            [
                'attribute' => 'hexcolor_category',
                'header' => '',
                'format' => 'raw',
                'value' => function ($model) {
                    return '<strong style="color:' . $model->hexcolor_category . '"><i class="fa fa-tag"></i></strong>';
                },
                'contentOptions' => ['style' => 'width: 3%; text-align:center'],
            ],
            [
                'attribute' => 'parent_id',
                'header' => '',
                'format' => 'raw',
                'enableSorting' => true,
                'value' => function ($model) {
                    return $model->parent ? $model->parent->desc_category . " > " . $model->desc_category : "<span class=\"text-danger\"><em>" . $model->desc_category . "</em></span>";
                },
                'contentOptions' => ['style' => 'width: 75%; text-align:left'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-edit hidden-xs"></span>',
                            $url,
                            [
                                'title' => Yii::t('app', 'Update'),
                                'data-pjax' => '0',
                            ]
                        );
                    },
                    'delete' => function ($url) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash hidden-xs"></span>',
                            $url,
                            [
                                'title' => Yii::t('app', 'Delete'),
                                'data-pjax' => '0',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), // Adicionando confirmação
                            ]
                        );
                    },
                ],
                'contentOptions' => ['style' => 'width: 20%; text-align:right'],
            ],
        ],
    ]); ?>
</div>
<style>
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .table {
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
        font-size: 1.7rem;
        /* Tamanho de fonte padrão */
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table-hover tbody tr:hover {
        background-color: #e9ecef;
        transform: scale(1.02);
        /* Aumenta a linha ao passar o mouse */
    }

    .alert {
        margin-bottom: 20px;
    }

    h2 {
        margin: 0;
        color: #007bff;
    }

    .category-index {
        margin-top: 20px;
    }

    .d-flex {
        display: flex;
    }

    .justify-content-between {
        justify-content: space-between;
    }

    .align-items-center {
        align-items: center;
    }

    .mb-3 {
        margin-bottom: 1rem;
    }
</style>