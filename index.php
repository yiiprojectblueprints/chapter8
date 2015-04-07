<?php

$config = require dirname(__FILE__).'/protected/config/main.php';
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

defined('YII_DEBUG') or define('YII_DEBUG',isset($config['params']['debug']) ? $config['params']['debug'] : false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',isset($config['params']['trace']) ? $config['params']['trace'] : 0);

// Requires
require_once(__DIR__ . '/vendor/autoload.php');
require(__DIR__.DS.'vendor'.DS.'yiisoft'.DS.'yii'.DS.'framework'.DS.(YII_DEBUG ? 'yii.php' : 'yiilite.php'));

// Enabled site tracing automagically
if (YII_DEBUG && YII_TRACE_LEVEL == 3)
{
	error_reporting(-1);
	ini_set('display_errors', 'true');

	// Enable WebLogRouteLogging
	$config['preload'][] = 'log';
	$config['components']['log']['routes'][0]['enabled'] = YII_DEBUG;
}

Yii::createWebApplication($config)->run();
