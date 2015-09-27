<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="category-index">
    <h2>
        <span><?= Html::encode($this->title) ?></span>
        <?= Html::a('<i class="fa fa-plus"></i> '.Yii::t('app', 'Create').'', ['/category/create'], ['class'=>'btn btn-primary grid-button pull-right']) ?>
    </h2>
    <hr/>
    <?php if ($flash = Yii::$app->session->getFlash("Category-success")): ?>
        <div class="alert alert-success"><p><em><?= $flash ?></em></p></div>
    <?php endif; ?>
    <?php if ($flash = Yii::$app->session->getFlash("Category-error")): ?>
        <div class="alert alert-danger"><p><em><?= $flash ?></em></p></div>
    <?php endif; ?>    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class'=>'table table-striped table-hover'],
        'summary'     =>  '',
        'rowOptions'   => function ($model, $index, $widget, $grid) {
                return [
                    'id' => $model['id_category'], 
                    'onclick' => 'location.href="'
                        . Yii::$app->urlManager->createUrl('category/view') 
                        . '&id="+(this.id);',
                    'style' => "cursor: pointer",
                ];
        },
        'columns' => [
            [
            'attribute' => 'hexcolor_category',
            'header' => '',
            'format' => 'raw',
            'value' => function ($model) {                      
                    return '<strong style="color:'.$model->hexcolor_category.'"><i class="fa fa-tag"></i></strong>';
                    },
            'contentOptions'=>['style'=>'width: 3%;text-align:right'],
            ],
            'desc_category',
            [
            'class' => 'yii\grid\ActionColumn',
            'contentOptions'=>['style'=>'width: 30%;text-align:right'],
            ],
        ],
    ]); ?>

</div>
