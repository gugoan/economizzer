<?php

use yii\helpers\Html;


$this->title = Yii::t('app', 'Tools');
?>
<div class="target-index">
<h2>
  <span><?php echo $this->title;?></span>
</h2>
<hr/>

<div class="row">
  <div class="col-md-6">
	<div class="panel panel-default">
	  <div class="panel-heading"><strong><?php echo Yii::t('app', 'Export Data');?></strong></div>
	  <div class="panel-body">
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
  <div class="col-md-6">

  </div>
</div>
</div>