<?php

use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\data\SqlDataProvider;
use yii\widgets\ActiveForm;
use app\models\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;

$this->title = 'Economizzer';
$this->title = Yii::t('app', 'Accomplishment');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
        <div class="col-sm-3">
            <?php  echo $this->render('_menu'); ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-9">
        <h2>
        	<span><?php echo $this->title; ?></span>
        </h2>
        <hr/>
        <div class="row">
        	<div class="panel panel-default">
                <div class="panel-heading"><strong><?php echo Yii::t('app', 'Track each category during the year');?></strong></div>
                <div class="panel-body">
                <?php 
		        $this->registerJs('var submit = function (val){if (val > 0) {
				    window.location.href = "' . Url::to(['/cashbook/accomplishment']) . '&category_id=" + val;
				}
				}', View::POS_HEAD);

		        echo Html::activeDropDownList($model, 'category_id', ArrayHelper::map(Category::find()->where(['user_id' => Yii::$app->user->identity->id])
                            ->orderBy("desc_category ASC")
                            ->all(), 'id_category', 'desc_category'), ['onchange'=>'submit(this.value);','prompt'=>Yii::t('app','Select'),'class'=>'form-control']);
                ?>
                </p>
				<?php
					echo Highcharts::widget([
				   'options' => [
				   		  'credits' => ['enabled' => false],
					      'title' => ['text' => ''],
					      'colors'=> ['#2C3E50'],
					      'xAxis' => [
					         'categories' => $m,
					      ],
					      'yAxis' => [
					         'title' => ['text' => ''],
					         'min'=> 0,
					      ],
					      'series' => [
					         ['name' => $n, 'data' => $v]
					      ]
					   ]
					]);
				?>	
				</div>
			</div>
        </div>
    </div>
</div>