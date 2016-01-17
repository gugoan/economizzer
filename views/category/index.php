<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Categories');
?>

<div class="category-index">
    <h2>
        <span><?= Html::encode($this->title) ?></span>
        <?= Html::a('<i class="fa fa-plus"></i> '.Yii::t('app', 'Create').'', ['/category/create'], ['class'=>'btn btn-primary grid-button pull-right']) ?>
    </h2>
    <hr/>

    <?php foreach (Yii::$app->session->getAllFlashes() as $key=>$message):?>
        <?php $alertClass = substr($key,strpos($key,'-')+1); ?>
        <div class="alert alert-dismissible alert-<?=$alertClass?>" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p><?=$message?></p>
        </div>
    <?php endforeach ?> 

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class'=>'table table-striped table-hover'],
        'summary'     =>  '',
        'rowOptions'   => function ($model, $index, $widget, $grid) {
                return [
                    'id' => $model['id_category'], 
                    'onclick' => 'location.href="'
                        . Yii::$app->urlManager->createUrl('category/') 
                        . '/"+(this.id);',
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
            [
            'attribute' => 'parent_id',
            'header' => '',
            'format' => 'raw',
            'enableSorting' => true,
            'value' => function ($model) {                      
                return $model->parent ? $model->parent->desc_category." > ".$model->desc_category : "<span class=\"text-danger\"><em>".$model->desc_category."</em></span>";
            },
            'contentOptions'=>['style'=>'width: 75%;text-align:left'],
            ],            
            // [
            // 'attribute' => 'desc_category',
            // 'format' => 'raw',
            // 'enableSorting' => true,
            // 'value' => function ($model) {                      
            //     return $model->is_active <> 1 ? '<del>'.$model->desc_category.'</del>' : $model->desc_category;
            //     },
            //  'contentOptions'=>['style'=>'width: 75%;text-align:left'],
            // ],
            
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
                                'title' => Yii::t('app', 'delete'),
                                'data-pjax' => '0',
                            ]
                        );
                    },                    
                ],
            'contentOptions'=>['style'=>'width: 20%;text-align:right'],
            ],
        ],
    ]); ?>
</div>
