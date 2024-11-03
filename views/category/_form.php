<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\color\ColorInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

?>

<div class="category-form container mt-5">
  <div class="form-container mx-auto p-4">

    <?php $form = ActiveForm::begin([
            'id' => 'categoryform',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'labelOptions' => ['class' => 'col-form-label font-weight-bold'],
                'template' => "<div class=\"form-group\">{label}{input}{error}</div>",
            ],
        ]); ?>

    <div class="form-grid">
      <!-- Primeira linha de inputs -->
      <div class="form-column">
        <?= $form->field($model, 'desc_category')->textInput(['maxlength' => 100, 'placeholder' => 'Descrição da categoria']) ?>
      </div>
      <div class="form-column">
        <?= $form->field($model, 'is_active')->radioList([
                    '1' => 'Sim',
                    '0' => 'Não',
                ], ['itemOptions' => ['class' => 'radio-inline', 'labelOptions' => ['style' => 'padding:5px;']]]) ?>


      </div>
      <div class="form-column">
        <?= $form->field($model, 'icone')->textInput(['maxlength' => 100, 'placeholder' => 'Classe do ícone (ex.: fa fa-tag)']) ?>
      </div>

      <!-- Segunda linha de inputs -->
      <div class="form-column">
        <?= $form->field($model, 'tipo')->dropDownList([
                    'gasto' => 'Gasto',
                    'receita' => 'Receita',
                    'ambos' => 'Ambos',
                ], ['prompt' => 'Selecione o tipo']) ?>
      </div>
      <div class="form-column">
        <?= $form->field($model, 'limite_orcamento')->textInput(['type' => 'number', 'step' => '0.01', 'placeholder' => 'Limite de orçamento (opcional)']) ?>
      </div>
      <div class="form-column">
        <?= $form->field($model, 'compartilhavel')->radioList([
                    '1' => 'Sim',
                    '0' => 'Não',
                ], ['itemOptions' => ['class' => 'radio-inline', 'labelOptions' => ['style' => 'padding:5px;']]]) ?>
      </div>

      <!-- Terceira linha de inputs -->
      <div class="form-column">
        <?= $form->field($model, 'tags')->textInput(['maxlength' => 255, 'placeholder' => 'Adicione tags separadas por vírgula']) ?>
      </div>
      <div class="form-column">
        <?= $form->field($model, 'regras_auto_categorizacao')->textarea(['rows' => 2, 'placeholder' => 'Insira as regras em formato JSON']) ?>
      </div>
      <div class="form-column">
        <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\Category::find()->where([
                        'parent_id' => null,
                        'user_id' => Yii::$app->user->identity->id,
                        'is_active' => 1
                    ])->orderBy("desc_category ASC")->all(), 'id_category', 'desc_category'),
                    'options' => ['placeholder' => 'Selecione a categoria pai'],
                    'pluginOptions' => ['allowClear' => true],
                ]); ?>
      </div>

      <!-- Quarta linha de inputs -->
      <div class="form-column">
        <?= $form->field($model, 'id_bancos')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\Bancos::find()->orderBy('nome')->all(), 'id_bancos', 'nome'),
                    'options' => ['placeholder' => 'Selecione o banco'],
                    'pluginOptions' => ['allowClear' => true],
                ]); ?>
      </div>
      <div class="form-column">
        <?= $form->field($model, 'id_clientes')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\Clientes::find()->orderBy('nome')->all(), 'id', 'nome'),
                    'options' => ['placeholder' => 'Selecione o cliente'],
                    'pluginOptions' => ['allowClear' => true],
                ]); ?>
      </div>
      <div class="form-column">
        <?= $form->field($model, 'id_produtos_clientes')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\ProdutosClientes::find()->orderBy('produto')->all(), 'id', 'produto'),
                    'options' => ['placeholder' => 'Selecione o produto/cliente'],
                    'pluginOptions' => ['allowClear' => true],
                ]); ?>
      </div>

      <!-- Última linha com um único input -->
      <div class="form-column" style="grid-column: span 3;">

        <?= $form->field($model, 'hexcolor_category')->widget(ColorInput::classname(), [
                    'options' => [
                        'placeholder' => 'Selecione a cor',
                        'class' => 'custom-color-input' // Classe personalizada
                    ],
                ]); ?>
      </div>
    </div>

    <?php ActiveForm::end(); ?>
  </div>
</div>

<!-- Botão de submissão flutuante centralizado -->
<div class="floating-save-btn text-center">
  <?= Html::submitButton('<i class="fa fa-save"></i> Salvar', [
        'class' => 'btn btn-primary btn-lg',
        'form' => 'categoryform' // Associa o botão ao formulário
    ]) ?>
</div>

<!-- CSS Customizado -->
<style>
.category-form {
  max-width: 960px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f8f9fa;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Grade de 3 colunas */
.form-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  /* 3 colunas iguais */
  gap: 20px;
  /* Espaçamento entre os elementos */
  justify-items: center;
  /* Centraliza os elementos em suas colunas */
}

/* Estilo para inputs */
input[type="text"],
textarea,
select,
input[type="number"],
.select2-container .select2-selection--single {
  border-radius: 8px;
  border: 1px solid #ced4da;
  padding: 10px;
  font-size: 1.7rem;
  width: 100%;
  /* Ocupa toda a largura da coluna */
  max-width: 300px;
  /* Limita a largura dos inputs */
  min-width: 300px;
  /* Garante a largura mínima */
  height: 45px;
  /* Altura consistente */
  background-color: #fff;
  transition: all 0.3s ease;
  /* Animação para hover */
}

/* Efeito hover para inputs */
input[type="text"]:hover,
textarea:hover,
select:hover,
input[type="number"]:hover,
.select2-container .select2-selection--single:hover {
  border-color: #007bff;
  /* Muda a cor da borda */
  transform: scale(1.02);
  /* Expande levemente */
  box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
  /* Adiciona uma sombra */
}

/* Ajustes para Select2 */
.select2-container .select2-selection--single {
  display: flex;
  align-items: center;
}

.select2-container .select2-selection__rendered {
  padding-left: 10px;
}

.select2-container .select2-selection__arrow {
  height: 100%;
  display: flex;
  align-items: center;
}

/* Botão flutuante centralizado */
.floating-save-btn {
  position: fixed;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 1000;
}

.btn-lg {
  padding: 10px 20px;
  border-radius: 25px;
  font-size: 1.2rem;
  background-color: #007bff;
  color: #fff;
  border: none;
  transition: all 0.3s ease;
  /* Animação para hover */
}

/* Efeito hover para botão */
.btn-lg:hover {
  background-color: #0056b3;
  /* Muda a cor de fundo */
  transform: scale(1.05);
  /* Expande levemente */
  box-shadow: 0 0 10px rgba(0, 86, 179, 0.2);
  /* Adiciona uma sombra */
}

.radio-inline {
  margin-right: 20px;
}

/* Placeholder */
input::placeholder,
textarea::placeholder {
  color: #6c757d;
  opacity: 0.9;
  font-size: 1.7rem;
}
</style>