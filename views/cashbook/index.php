<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Cashbook;

$this->title = Yii::t('app', 'Entries');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
        <div class="col-sm-3">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <strong><?php echo Yii::t('app', 'Filters');?>
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">
                      <span class="glyphicon glyphicon-resize-small pull-right" aria-hidden="true"></span>
                    </a>
                  </strong>
                </div>
                <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="col-sm-9">

    <div class="cashbook-index">
    <h2>
      <span><?= Html::encode($this->title) ?></span>
        <?= Html::a('<i class="fa fa-plus"></i> '.Yii::t('app', 'Create').'', ['/cashbook/create'], ['class'=>'btn btn-primary grid-button pull-right']) ?>
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
        'emptyText'    => '</br><p class="text-danger">'.Yii::t('app', 'No entries found!').'</p>',
        'summary'      =>  '',
        'showFooter'   => true,
        'showOnEmpty'  => false,
        'footerRowOptions'=>['style'=>'font-weight:bold;'],
        'rowOptions'   => function ($model, $index, $widget, $grid) {
                return [
                    'id' => $model['id'], 
                    'onclick' => 'location.href="'
                        . Yii::$app->urlManager->createUrl('cashbook/') 
                        . '/"+(this.id);',
                    'style' => "cursor: pointer",
                ];
        },        
        'columns'    => [
            [
            'attribute' => 'date',
            'enableSorting' => true,
            'value' => function ($model) {                      
                    return $model->date <> '' ? Yii::$app->formatter->asDate($model->date, 'short') : Yii::$app->formatter->asDate($model->date, 'short');
                    },
             'contentOptions'=>['style'=>'width: 15%;text-align:left'],
            ],
            [
            'attribute' => 'category_id',
            'format' => 'raw',
            'enableSorting' => true,
            'value' => function ($model) {                      
                    return $model->description <> '' ? '<span style="color:'.$model->category->hexcolor_category.'">'.$model->category->desc_category.'</span>'.' <em class="text-muted">('.$model->description.')</em>' : '<span style="color:'.$model->category->hexcolor_category.'">'.$model->category->desc_category.'</span>';
                    },
            'contentOptions'=>['style'=>'width: 55%;text-align:left'],
            'footer' => 'Total',
            'footerOptions' => ['style'=>'text-align:letf'],                  
            ],
            [
             'label' => '',
             'attribute' => 'value',
             'format' => 'raw',
             'value' => function ($model) {  
                    return $model->is_pending === 0 ? '<strong style="color:'.$model->type->hexcolor_type.'">'.' '.number_format($model->value,2,Yii::$app->formatter->decimalSeparator,' ').'</strong>' :
                    '<span class="glyphicon glyphicon-flag" style="color:orange" aria-hidden="true"></span> <strong style="color:'.$model->type->hexcolor_type.'">'.' '.number_format($model->value,2,Yii::$app->formatter->decimalSeparator,' ').'</strong>';
                    },
             'enableSorting' => true,
             'contentOptions'=>['style'=>'width: 30%;text-align:right'],
             //'options' => ['width' => '10%',],
             'footer' => Cashbook::pageTotal($dataProvider->models,'value'),
             'footerOptions' => ['style'=>'text-align:right'],
            ],
        ],
    ]);
     ?>
     <hr/>
     <div class="pull-left">
          <?php
          use kartik\export\ExportMenu;
              $gridColumns = [
                  ['attribute'=>'date','format'=>['date'], 'hAlign'=>'right', 'width'=>'110px'],  
              [
                  'attribute'=>'category_id',
                  'label'=> Yii::t('app', 'Category'),
                  'vAlign'=>'middle',
                  'width'=>'190px',
                  'value'=>function ($model, $key, $index, $widget) { 
                      return Html::a($model->category->desc_category, '#', []);
                  },
                  'format'=>'raw'
              ],                    
                  ['attribute'=>'value','format'=>['decimal',2], 'hAlign'=>'right', 'width'=>'110px'],
              ];
              echo ExportMenu::widget([
              'dataProvider' => $dataProvider,
              'columns' => $gridColumns,
              'fontAwesome' => true,
              'emptyText' => Yii::t('app', 'No entries found!'),
              'showColumnSelector' => true,
              'asDropdown' => true,
              'target' => ExportMenu::TARGET_BLANK,
              'showConfirmAlert' => false,
              'exportConfig' => [
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_PDF => false
            ],
            'columnSelectorOptions' => [
              'class' => 'btn btn-primary btn-sm',
            ],
            'dropdownOptions' => [
              'label' => Yii::t('app', 'Export Data'),
              'class' => 'btn btn-primary btn-sm',
            ],
            ]);
          ?>    
     </div>
    </div>
    </div>
</div>
