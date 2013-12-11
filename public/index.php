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

/**
 * delete this
 */
defined('YII_DEBUG') or define('YII_DEBUG', true);

if (APPLICATION_ENV == 'development') {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    $config = dirname(__FILE__) . '/../protected/config/development.php';
}

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

/**
 * This function is used in debug
 * @param mixed $var variable to debug
 * @param bool  $needToExit if you want to stop application
 */
function D($var, $needToExit = false)
{
    if (YII_DEBUG) {
        if (array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER)) {

            var_dump($var);

        } else {
            CVarDumper::dump($var, 20, 1);
            echo '<br />';
        }

        if ($needToExit) {
            try {
                Yii::app()->end();
            } catch (Exception $e) {
                exit;
            }
        }
    }
}

require_once($yii);
Yii::createWebApplication($config)->run();
