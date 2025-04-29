<?php

use yii\helpers\Html;

$this->title = 'Atualizar Categoria: ' . $model->desc_category;
?>
<div class="category-update text-center">

  <h2 class="font-weight-bold mb-4"><?= Html::encode($this->title) ?></h2>
  <hr class="mb-4" />

  <div class="form-container">
    <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
  </div>

</div>

<!-- CSS Customizado -->
<style>
.category-update {
  max-width: 960px;
  margin: 0 auto;
}

h2 {
  font-size: 2rem;
  color: #333;
}

hr {
  border: 0;
  border-top: 2px solid #007bff;
  width: 50%;
  margin: 0 auto;
}
</style>