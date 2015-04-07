<?php

// change the following paths if necessary
$config=dirname(__FILE__).'/config/main.php';

$config = require($config);

error_reporting(-1);
ini_set('display_errors', 'true');
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
require(__DIR__.DS.'..'.DS.'vendor'.DS.'yiisoft'.DS.'yii'.DS.'framework'.DS.'yiic.php');
