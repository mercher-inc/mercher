<?php

return array(
    'basePath'   => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'       => 'My Console Application',
    'preload'    => array('log'),
    'import'     => array(
        'application.models.*',
        'application.components.*',
    ),
    'commandMap' => array(
        'migrate' => array(
            'class'          => 'system.cli.commands.MigrateCommand',
            'migrationTable' => 'migrations',
        ),
    ),
    'components' => array(
        'db'  => require(dirname(__FILE__) . '/db.php'),
        'log' => array(
            'class'  => 'CLogRouter',
            'routes' => array(
                array(
                    'class'  => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
    ),
);