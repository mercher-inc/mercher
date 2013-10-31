<?php

date_default_timezone_set('UTC');

// change the following paths if necessary
$yii    = dirname(__FILE__) . '/../yii/framework/yii.php';
$config = dirname(__FILE__) . '/../protected/config/main.php';

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ?
    getenv('APPLICATION_ENV') :
    'production'));

if (APPLICATION_ENV == 'development') {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    $config = dirname(__FILE__) . '/../protected/config/development.php';
}

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once($yii);
Yii::createWebApplication($config)->run();
