<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'economizzer',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        [
            'class' => 'app\components\LanguageSelector',
            'supportedLanguages' => ['en', 'pt-br', 'ru', 'ko'],
        ],
    ],
    //'defaultRoute' => 'cashbook/index',
    'sourceLanguage' => 'en-US',
    'components' => [
        // 'formatter' => [
        //     'class' => 'yii\i18n\formatter',
        //     'thousandSeparator' => '.',
        //     'decimalSeparator' => ',',
        // ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => array(
                    '<controller:\w+>/<id:\d+>' => '<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],
        'request' => [
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
                        '@vendor/amnah/yii2-user/views/default' => '@app/views/user',
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
                'from' => ['master@economizzer.com' => 'Admin'],
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
                ],
            ],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '',
                    'clientSecret' => '',
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '',
                    'clientSecret' => '',
                    'scope' => 'email',
                ],
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
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
        ],
        'user' => [
            'class' => 'amnah\yii2\user\Module',
            'controllerMap' => [
                'default' => 'app\controllers\UserController',
                'auth' => 'app\controllers\AuthController'
            ],
            'modelClasses'  => [
                'Profile' => 'app\models\Profile',
            ],
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
