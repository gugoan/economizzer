<?php

use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;
use yii\web\View;
use app\models\Category;

$this->title = Yii::t('app', 'Accomplishment');
?>
<div class="dashboard-index">
	<div class="row">
		<div class="col-md-6">
			<?php echo $this->render('_menu'); ?>
		</div>
		<div class="col-md-6"></div>
	</div>
	<hr />
	<div class="row">
		<div class="container-fluid">
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<strong><?php echo Yii::t('app', 'Track each category during the year'); ?></strong>
				</div>
				<div class="col-xs-9 col-md-4 pull-right">
					<?php
					// Registra o JS para capturar o evento de mudança no dropdown
					$this->registerJs('
                        var submit = function (val) {
                            if (val > 0) {
                                window.location.href = "' . Url::to(['/dashboard/accomplishment']) . '?category_id=" + val;
                            }
                        };
                    ', View::POS_HEAD);

					// Dropdown para selecionar a categoria
					echo Html::activeDropDownList(
						$model,
						'category_id',
						Category::getHierarchy(),
						[
							'onchange' => 'submit(this.value);',
							'prompt' => Yii::t('app', 'Select'),
							'class' => 'form-control'
						]
					);
					?>
				</div>
				<div class="panel-body">
					<?php
					// Verifica se há dados para exibir no gráfico
					if (!empty($m) && !empty($v)) {
						// Gera o gráfico utilizando Highcharts
						echo Highcharts::widget([
							'options' => [
								'credits' => ['enabled' => false],
								'title' => ['text' => ''],
								'colors' => ['#2C3E50'],
								'xAxis' => [
									'categories' => $m, // Meses
								],
								'yAxis' => [
									'title' => ['text' => ''],
									'min' => 0,
								],
								'series' => [
									['name' => $n, 'data' => $v] // Dados da categoria
								]
							]
						]);
					} else {
						echo "<p>" . Yii::t('app', 'No data available for the selected category.') . "</p>";
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>