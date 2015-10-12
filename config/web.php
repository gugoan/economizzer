<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'economizzer',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        [
            'class' => 'app\components\LanguageSelector',
            'supportedLanguages' => ['en', 'pt-br', 'ru'],
        ],
    ],
    'defaultRoute' => 'cashbook/index',
    //'language' => 'en',
    'sourceLanguage' => 'en-US',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'eco',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'amnah\yii2\user\components\User',
            'identityClass' => 'app\models\User',
        ],
        'view' => [
                'theme' => [
                    'pathMap' => [
                        '@vendor/amnah/yii2-user/views/default' => '@app/views/user', // example: @app/views/user/default/login.php
                    ],
                ],
            ],        
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
            'messageConfig' => [
                'from' => ['master@economizzer.com' => 'Admin'], // this is needed for sending emails
                'charset' => 'UTF-8',
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'i18n' => [
        'translations' => [
                '*' => [
                        'class' => 'yii\i18n\PhpMessageSource',
                        'basePath' => '@app/messages',
                        //'on missingTranslation' => ['app\components\TranslationEventHandler', 'handleMissingTranslation'],
                ],
            ],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'app\components\GoogleOAuth',
                    'clientId' => '',
                    'clientSecret' => '',
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '',
                    'clientSecret' => '',
                    'scope' => 'email',
                ],
                // 'twitter' => [
                //     'class' => 'yii\authclient\clients\Twitter',
                //     'consumerKey' => '',
                //     'consumerSecret' => '',
                // ],
                // 'vkontakte' => [
                //     'class' => 'yii\authclient\clients\VKontakte',
                //     'clientId' => '',
                //     'clientSecret' => '', // @deploy - set in main-local.php
                //     'scope' => '4194304', // 4194304 in vk API bit masks means 'email'
                // ],
            ]
        ],
        'assetManager' => [
            'bundles' => [
                'yii\authclient\widgets\AuthChoiceStyleAsset' => [
                    'sourcePath' => '@app/widgets/authchoice/assets',
                ],
            ],
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'amnah\yii2\user\Module',
            'controllerMap' => [
                'default' => 'app\controllers\UserController',
                'auth' => 'app\controllers\AuthController'
            ],
            'modelClasses'  => [
                'Profile' => 'app\models\Profile',
            ],
            // set custom module properties here ...
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
