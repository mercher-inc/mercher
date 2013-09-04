<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'   => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'       => 'My Web Application',
    // preloading 'log' component
    'preload'    => array('log'),
    // autoloading model and component classes
    'import'     => array(
        'application.models.*',
        'application.components.*',
    ),
    'modules'    => array(// uncomment the following to enable the Gii tool
        /*
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'Enter Your Password Here',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
        ),
        */
    ),
    // application components
    'components' => array(
        'user'         => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        'urlManager'   => array(
            'urlFormat'      => 'path',
            'urlSuffix'      => '.html',
            'caseSensitive'  => false,
            'showScriptName' => false,
            'rules'=>array(
                '' => 'index/index',
                '<action:(login|logout|contact)>' => 'index/<action>',
            ),
        ),
        'db'           => array(
            'connectionString' => 'pgsql:host=localhost;port=5432;dbname=mercher',
            'emulatePrepare'   => true,
            'username'         => 'postgres',
            'password'         => 'postgres',
            'charset'          => 'utf8',
        ),
        'errorHandler' => array(
            // use 'index/error' action to display errors
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
        'facebook'     => array(
            'class'  => 'FB',
            'appId'  => '631238416902634',
            'secret' => '4dfa1e0fef9fc2bf785d2a8d36e415a3'
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'     => array(
        // this is used in contact page
        'adminEmail' => 'support@mercher.dev',
    ),
);