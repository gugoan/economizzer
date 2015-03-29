<?php

use yii\bootstrap\Nav;

            echo Nav::widget([
                'items' => [
                    [
                        'label' => Yii::t('app', 'Monthly Summary'), 'active'=>true,
                        'url' => ['site/index'],
                        'options' => ['class' => 'active','role'=>'presentation'],
                        //'items' => [
                        //     ['label' => 'Semanal', 'url' => '#'],
                        //     ['label' => 'Media', 'url' => '#'],
                        //],
                    ],
                    [
                        'label'   => Yii::t('app', 'Accomplishment'),
                        'url'     => ['site/accomplishment'],
                        'active'  => false,
                        //'options' => ['class' => 'disabled'],
                    ],
                    [
                        'label'   => Yii::t('app', 'Annual Performance'),
                        'url'     => ['site/performance'],
                        'active'  => false,
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