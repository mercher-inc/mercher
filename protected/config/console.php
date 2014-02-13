<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),
    // autoloading model and component classes
    'import'         => array(
        'application.models.*',
        'application.components.*',
    ),

    'commandMap' => array(
        'migrate' => array(
            'class'          => 'system.cli.commands.MigrateCommand',
            'migrationTable' => 'migrations',
        ),
    ),
	// application components
	'components'=>array(
        'db'=>array(
            'connectionString' => 'pgsql:host=localhost;dbname=mercher',
            'emulatePrepare' => true,
            'username' => 'postgres',
            'password' => 'postgres',
            'charset' => 'utf8',
        ),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);