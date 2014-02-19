<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
//var_dump(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'forms')); die;
Yii::setPathOfAlias('forms', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'forms');
Yii::setPathOfAlias(
    'PayPalComponent',
    dirname(
        __FILE__
    ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'PayPalComponent'
);

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'       => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    //'baseUrl'       => 'http://mercher.dev/',
    'name'           => 'Mercher',
    // preloading 'log' component
    'preload'        => array('log'),
    'sourceLanguage' => 'pseudo',
    'language'       => 'en_US',
    // autoloading model and component classes
    'import'         => array(
        'application.models.*',
        'application.components.*',
        'ext.yii-mail.YiiMailMessage',
    ),
    'modules'        => array( // uncomment the following to enable the Gii tool
        'gii' => array(
            'class'     => 'system.gii.GiiModule',
            'password'  => '123',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
        'api',
        'tab',
        'management'
    ),
    // application components
    'components'     => array(
        'mail'         => [
            'class'            => 'ext.yii-mail.YiiMail',
            'transportType'    => 'smtp',
            'viewPath'         => 'application.views.mail',
            'logging'          => true,
            'dryRun'           => false,
            'transportOptions' => require(dirname(__FILE__) . '/mail/transportOptions.php'),
        ],
        'user'         => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'loginUrl'       => array('index/index'),
        ),
        'urlManager'   => array(
            'class'          => 'UrlManager',
            'urlFormat'      => 'path',
            'urlSuffix'      => '.html',
            'baseUrl'        => 'http://' . $_SERVER['HTTP_HOST'],
            'caseSensitive'  => false,
            'showScriptName' => false,
            'rules'          => require(dirname(__FILE__) . '/urlManager/rules.php'),
        ),
        'authManager'  => [
            'class' => 'AuthManager',
        ],
        'clientScript' => array(
            'class'    => 'ClientScript',
            'packages' => require(dirname(__FILE__) . '/clientScript/packages.php'),
        ),
        'db'           => require(dirname(__FILE__) . '/db.php'),
        'errorHandler' => array(
            'class'       => 'ErrorHandler',
            'errorAction' => 'index/error',
        ),
        'log'          => array(
            'class'  => 'CLogRouter',
            'routes' => array(
                array(
                    'class'  => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            ),
        ),
        'cache'        => array(
            'class' => 'system.caching.CFileCache'
        ),
        'facebook'     => require(dirname(__FILE__) . '/facebook.php'),
        'paypal'       => array(
            'class'         => '\PayPalComponent\Client',
            'applicationId' => 'APP-80W284485P519543T',
            'userId'        => 'dmitriy.s.les-facilitator_api1.gmail.com',
            'password'      => '1391764851',
            'signature'     => 'AIkghGmb0DgD6MEPZCmNq.bKujMAA8NEIHryH-LQIfmx7UZ5q1LXAa7T',
            'primaryEmail'  => 'dmitriy.s.les-facilitator@gmail.com',
            'baseUrl'       => 'https://svcs.sandbox.paypal.com/'
        )
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'         => array(
        // this is used in contact page
        'adminEmail' => 'support@mercher.net',
        'isApp'      => preg_match('/^app./', $_SERVER['HTTP_HOST'])
    ),
);