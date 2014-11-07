<?php

Yii::setPathOfAlias('forms', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'forms');
Yii::setPathOfAlias(
    'PayPalComponent',
    dirname(
        __FILE__
    ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'PayPalComponent'
);

return [
    'basePath'       => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'           => 'Mercher',
    'preload'        => ['log'],
    'sourceLanguage' => 'pseudo',
    'language'       => 'en_US',
    'import'         => [
        'application.models.*',
        'application.components.*',
        'ext.yii-mail.YiiMailMessage',
    ],
    'modules'        => [
        /*'gii' => [
            'class'     => 'system.gii.GiiModule',
            'password'  => '123',
            'ipFilters' => ['127.0.0.1', '::1'],
        ],*/
        'api',
        'tab',
        'management',
        'export'
    ],
    'components'     => [
        'mail'         => [
            'class'            => 'ext.yii-mail.YiiMail',
            'transportType'    => 'smtp',
            'viewPath'         => 'application.views.mail',
            'logging'          => true,
            'dryRun'           => false,
            'transportOptions' => require(dirname(__FILE__) . '/mail/transportOptions.php'),
        ],
        'user'         => [
            'allowAutoLogin' => true,
            'loginUrl'       => ['index/index'],
        ],
        'urlManager'   => [
            'class'          => 'UrlManager',
            'urlFormat'      => 'path',
            'urlSuffix'      => '.html',
            'baseUrl'        => 'http://' . $_SERVER['HTTP_HOST'],
            'caseSensitive'  => false,
            'showScriptName' => false,
            'rules'          => require(dirname(__FILE__) . '/urlManager/rules.php'),
        ],
        'authManager'  => [
            'class' => 'AuthManager',
        ],
        'clientScript' => [
            'class'    => 'ClientScript',
            'packages' => require(dirname(__FILE__) . '/clientScript/packages.php'),
        ],
        'db'           => require(dirname(__FILE__) . '/db.php'),
        'errorHandler' => [
            'class'       => 'ErrorHandler',
            'errorAction' => 'index/error',
        ],
        'log'          => [
            'class'  => 'CLogRouter',
            'routes' => [
                [
                    'class'  => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ],
                [
                    'class'      => 'CFileLogRoute',
                    'logFile'    => 'PayPalComponent.log',
                    'categories' => 'PayPalComponent.*',
                ],
                [
                    'class'      => 'CFileLogRoute',
                    'logFile'    => 'IpnNotifications.log',
                    'categories' => 'IpnNotification',
                ],
            ],
        ],
        'cache'        => [
            'class' => 'system.caching.CFileCache'
        ],
        'facebook'     => require(dirname(__FILE__) . '/facebook.php'),
        'paypal'       => require(dirname(__FILE__) . '/paypal.php')
    ],
    'params'         => [
        'adminEmail' => 'support@mercher.net',
        'isApp'      => preg_match('/^app./', $_SERVER['HTTP_HOST'])
    ],
];