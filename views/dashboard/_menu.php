<?php

use yii\bootstrap\Nav;

// Obter a aba ativa a partir da URL
$activeTab = Yii::$app->request->get('tab', 'overview');

echo Nav::widget([
    'activateItems' => true,
    'encodeLabels' => false,
    'items' => [
        [
            'label' => Yii::t('app', 'Monthly Summary'),
            'url' => ['/dashboard/overview', 'tab' => 'overview'],
            'active' => $activeTab === 'overview',
            'visible' => !Yii::$app->user->isGuest,
        ],
        [
            'label' => Yii::t('app', 'Analysis by Category'),
            'url' => ['/dashboard/accomplishment', 'tab' => 'accomplishment'],
            'active' => $activeTab === 'accomplishment',
            'visible' => !Yii::$app->user->isGuest,
        ],
        [
            'label' => Yii::t('app', 'Annual Performance'),
            'url' => ['/dashboard/performance', 'tab' => 'performance'],
            'active' => $activeTab === 'performance',
            'visible' => !Yii::$app->user->isGuest,
        ],
    ],
    'options' => ['class' => 'nav nav-tabs'], // Mudando para nav-tabs para estilo de abas
]);

// Adicionar o conteúdo a ser exibido quando uma aba for clicada
echo '<div class="tab-content">';
echo '<div class="tab-pane' . ($activeTab === 'overview' ? ' active' : '') . '" id="overview">';
echo '</div>';
echo '<div class="tab-pane' . ($activeTab === 'accomplishment' ? ' active' : '') . '" id="accomplishment">';
echo '</div>';
echo '<div class="tab-pane' . ($activeTab === 'performance' ? ' active' : '') . '" id="performance">';
echo '</div>';
echo '</div>';
