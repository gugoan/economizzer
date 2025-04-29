<?php

namespace app\assets;  // Certifique-se de usar o namespace correto para sua aplicação

use yii\web\AssetBundle;

class ClientesAsset extends AssetBundle
{
  public $basePath = '@webroot';   // Diretório base dos arquivos estáticos (geralmente a pasta "web")
  public $baseUrl = '@web';        // URL pública para acessar esses arquivos

  public $css = [
    'css/clientes.css',            // Referência para o arquivo CSS
  ];



  public $depends = [
    'yii\web\YiiAsset',          // Dependência do Yii2 para carregamento básico
    'yii\bootstrap\BootstrapAsset', // Dependência para carregar o Bootstrap (caso use)
  ];
}