<?php

use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\data\SqlDataProvider;
use yii\widgets\ActiveForm;
use app\models\Category;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CashbookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Economizzer';
$this->title = Yii::t('app', 'Accomplishment');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
        <div class="col-xs-6 col-md-3">
            <?php  echo $this->render('_menu'); ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-9">
        <h2>
          <span><?php echo $this->title; ?></span>
        </h2>
        <hr/>
        <?php 
		// debug
		// var_dump($v);
		// echo "</br>";
		// var_dump($m);
		?>
        <div class="row">

		        <?php $form = ActiveForm::begin([
				        'id' => 'accomplishment-form',
				        'options' => ['class' => 'form-horizontal'],
				        'fieldConfig' => [
				            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
				            'labelOptions' => ['class' => 'col-lg-2 control-label'],
				        ],
				        'action' => ['accomplishment'],
        				'method' => 'get',
    			]); ?>
		        <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->where(['user_id' => Yii::$app->user->identity->id])->orderBy("desc_category ASC")->all(), 'id_category', 'desc_category'),['onchange'=>'this.form.submit()','prompt'=>'-- Selecione --'])  ?>
		        <?php ActiveForm::end(); ?>


			<?php
				echo Highcharts::widget([
			   'options' => [
			   		  'credits' => ['enabled' => false],
				      'title' => ['text' => ''],
				      'colors'=> ['#18bc9c','#e74c3c'],
				      'xAxis' => [
				         'categories' => $m,
				      ],
				      'yAxis' => [
				         'title' => ['text' => '']
				      ],
				      'series' => [
				         //['name' => 'Jane', 'data' => [1, 0, 4]],
				         ['name' => 'Cemig', 'data' => $v]
				      ]
				   ]
				]);
			?>
        </div>
            
            </div>
        </div>