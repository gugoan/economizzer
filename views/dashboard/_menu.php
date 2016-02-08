<?php

use yii\bootstrap\Nav;

            echo Nav::widget([
                'activateItems' => true,
                'encodeLabels' => false,
                'items' => [
                    
                    // [
                    //     'label'   => Yii::t('app', 'Top 5'),
                    //     'url'     => ['site/index'],
                    //     'active'  => false,
                    //     'options' => ['class' => 'disabled'],
                    // ],
                    // [
                    //     'label'   => Yii::t('app', 'Detailed'),
                    //     'url'     => ['site/index'],
                    //     'active'  => false,
                    //     'options' => ['class' => 'disabled'],
                    // ],
                    
                    [
                        'label' => 'Relatório',
                        'items' => [
[
                        'label' => Yii::t('app', 'Monthly Summary'),
                        'url' => ['/dashboard/overview'],
                        'visible' => !Yii::$app->user->isGuest,
                        //'options' => ['class' => 'active','role'=>'presentation'],
                        //'items' => [
                        //     ['label' => 'Semanal', 'url' => '#'],
                        //     ['label' => 'Media', 'url' => '#'],
                        //],
                    ],
                    [
                        'label'   => Yii::t('app', 'Accomplishment'),
                        'url'     => ['/dashboard/accomplishment'],
                        'visible' => !Yii::$app->user->isGuest,
                        //'active'  => true,
                        //'options' => ['class' => 'disabled'],
                    ],
                    [
                        'label'   => Yii::t('app', 'Annual Performance'),
                        'url'     => ['/dashboard/performance'],
                        'visible' => !Yii::$app->user->isGuest,
                        //'active'  => false,
                        //'options' => ['class' => 'disabled'],
                    ],
                        ],
                    ],
                    
                ],
                'options' => ['class' =>'nav-pills nav-stacked'], // set this to nav-tab to get tab-styled navigation
            ]);
            ?>