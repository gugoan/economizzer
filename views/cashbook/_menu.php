<?php

use yii\bootstrap\Nav;

            echo Nav::widget([
                'activateItems' => true,
                'items' => [
                    [
                        'label' => Yii::t('app', 'Monthly Summary'),
                        'url' => ['/cashbook/overview'],
                        'visible' => !Yii::$app->user->isGuest,
                        //'options' => ['class' => 'active','role'=>'presentation'],
                        //'items' => [
                        //     ['label' => 'Semanal', 'url' => '#'],
                        //     ['label' => 'Media', 'url' => '#'],
                        //],
                    ],
                    [
                        'label'   => Yii::t('app', 'Accomplishment'),
                        'url'     => ['/cashbook/accomplishment'],
                        'visible' => !Yii::$app->user->isGuest,
                        //'active'  => true,
                        //'options' => ['class' => 'disabled'],
                    ],
                    [
                        'label'   => Yii::t('app', 'Annual Performance'),
                        'url'     => ['/cashbook/performance'],
                        'visible' => !Yii::$app->user->isGuest,
                        //'active'  => false,
                        //'options' => ['class' => 'disabled'],
                    ],
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
                    /*
                    [
                        'label' => 'Dropdown',
                        'items' => [
                             ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
                             '<li class="divider"></li>',
                             '<li class="dropdown-header">Dropdown Header</li>',
                             ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
                        ],
                    ],
                    */
                ],
                'options' => ['class' =>'nav-pills nav-stacked'], // set this to nav-tab to get tab-styled navigation
            ]);
            ?>