<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PdfUploadForm */

$this->title = Yii::t('app', 'Envio de Fatura em PDF ou CSV');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Faturas'), 'url' => ['faturas/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="pdf-upload-form container mt-5 p-4 rounded shadow-sm"
  style="max-width: 600px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">

  <h1 class="text-center mb-3" style="font-weight: 600; font-size: 2em; color: #2c3e50;">Envio de Fatura em PDF ou CSV
  </h1>

  <p class="text-center mb-4" style="font-size: 1.1em; color: #5d6d7e;">
    Carregue seu arquivo PDF ou CSV contendo os dados da fatura para registrá-los automaticamente em sua conta.
    Simplifique o
    processo de acompanhamento!
  </p>

  <div class="col-md-12">
    <?php $form = ActiveForm::begin([
      'id' => 'pdfuploadform',
      'action' => ['fatura-upload/upload-faturas', 'id_bancos' => $id_bancos],
      'options' => [
        'enctype' => 'multipart/form-data', // Necessário para upload de arquivos
        'class' => 'form-horizontal',
        'onsubmit' => 'showProgressBar()'
      ],
    ]); ?>

    <?= Html::hiddenInput('id_bancos', $id_bancos); ?>
    <!-- Campo oculto para id_bancos -->

    <div class="form-group text-center mb-4">
      <label for="file-upload" class="btn btn-outline-primary"
        style="display: inline-block; padding: 10px 20px; font-size: 1.1em; border-radius: 5px; cursor: pointer; background-color: #e7f3ff; color: #2c3e50;">
        <i class="fa fa-file"></i> Escolher arquivo PDF ou CSV
      </label>
      <input type="file" id="file-upload" name="FaturaPdfUploadForm[file]" accept=".pdf, .csv" style="display: none;" />
      <br>

      <small class="form-text text-muted text-center mt-2" style="font-size: 0.95em; color: #5d6d7e;">
        Somente arquivos PDF ou CSV são aceitos.
      </small>
    </div>

    <!-- Barra de progresso oculta, será exibida no envio -->
    <div class="progress" style="height: 25px; display: none;" id="upload-progress-bar">
      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
        style="width: 0%; background-color: #3498db; font-weight: bold;" aria-valuenow="0" aria-valuemin="0"
        aria-valuemax="100">
        0%
      </div>
    </div>

    <!-- Botão de envio estilizado -->
    <div class="form-group text-center mt-4">
      <?= Html::submitButton('<i class="fa fa-upload"></i> ' . Yii::t('app', 'Enviar e Processar Fatura'), [
        'class' => 'btn',
        'style' => 'padding: 12px 28px; font-size: 1.1em; color: white; background-color: #3498db; border-radius: 30px; transition: background-color 0.3s, transform 0.3s; box-shadow: 0 4px 12px rgba(52, 152, 219, 0.4);',
      ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
  </div>
</div>

<script>
// Atualiza o nome do arquivo no botão após a seleção e ajusta o rótulo
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('file-upload').addEventListener('change', function() {
    var fileName = this.files[0] ? this.files[0].name : 'Escolher arquivo PDF ou CSV';
    document.querySelector('label[for="file-upload"]').innerHTML = '<i class="fa fa-file"></i> ' +
      fileName;
  });
});

// Exibe a barra de progresso e simula o progresso do upload
function showProgressBar() {
  var progressBar = document.getElementById('upload-progress-bar');
  var progressBarInner = progressBar.querySelector('.progress-bar');
  progressBar.style.display = 'block'; // Mostra a barra de progresso

  var progress = 0;
  var interval = setInterval(function() {
    if (progress < 100) {
      progress += 10; // Incrementa o progresso
      progressBarInner.style.width = progress + '%';
      progressBarInner.setAttribute('aria-valuenow', progress);
      progressBarInner.textContent = progress + '%'; // Exibe a porcentagem na barra
    } else {
      clearInterval(interval); // Para o intervalo ao atingir 100%
    }
  }, 300); // Intervalo para atualizar a barra de progresso
}
</script>