<?php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '../.env');
$dotenv->load();

require_once(__DIR__.'/debug.php');
$ip = require(__DIR__ . '/../config/ip_white_list.php');
$params = require(__DIR__ . '/params.php');
$keys = require(__DIR__ . '/keys.php');

$config = [
    'id' => 'basic',
    'name' => 'hike-app.nl',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@kvgrid' => '/vendor/kartik-v',
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'bootstrap' => [
        'log',
        [
            'class' => 'app\components\LanguageSelector',
            'supportedLanguages' => ['nl_NL'],
            // TODO:
            //'supportedLanguages' => ['en_US', 'nl_NL'],
        ],
        'app\components\Bootstrap',
        'devicedetect'
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'modelMap' => [
                'User' => 'app\models\Users'
            ],
            'mailer' => [
                'sender' => ['noreply@hike-app.nl' => 'hike-app.nl'],
            ],
            'enableRegistration' => $_ENV['ENABLE_REGISTRATION'],
            'admins' => ['dasman'],
            'debug' => $_ENV['YII_DEBUG'],
        ],
        'rbac' => 'dektrium\rbac\RbacWebModule',
        'gridview' =>  [
             'class' => '\kartik\grid\Module'
        ],
        // Configure text editor module
        'redactor' => 'yii\redactor\RedactorModule',
    ],
    'timeZone' => 'Europe/Amsterdam', // this is my default
    'components' => [
        'authManager' => [
            'class' => 'dektrium\rbac\components\DbManager',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                    //'on missingTranslation' => ['app\components\TranslationEventHandler', 'handleMissingTranslation']
                ],
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
            'defaultTimeZone' => 'Europe/Amsterdam',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => $keys['cookieValidationKey'],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
            'maxSourceLines' => 20,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => $_ENV['EMAIL_TO_FILE'] ,
            'transport' => require(__DIR__ . '/email.php')
        ],
        'log' => [
            'traceLevel' => $_ENV['YII_DEBUG'] ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'setupdatetime' => [
            'class' => 'app\components\SetupDateTime',
        ],
        'assetManager' => [
            'bundles' => [
            ]
        ],
        'db' => require(__DIR__ . '/db.php'),
        'devicedetect' => [
      		  'class' => 'alexandernst\devicedetect\DeviceDetect'
      	],
        'user' => [
            'identityClass' => 'app\models\Users',
            'enableAutoLogin' => true,
            'authTimeout' => 86400,
         ]
    ],
    'params' => $params,
];

if ($_ENV['YII_ENV'] == 'dev' || $_ENV['YII_ENV'] == 'test') {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => $ip,
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => $ip,
    ];
}

return $config;
