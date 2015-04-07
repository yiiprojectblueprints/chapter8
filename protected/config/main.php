<?php return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'CMS',
	'import'=>array(
		'application.models.*',
		'application.components.*'
	),

	'modules' => require_once __DIR__ . DIRECTORY_SEPARATOR . 'modules.php',
	
	'components'=>array(
		//CREATE USER 'ch6_cms'@'localhost' IDENTIFIED BY 'ch6_cms';
		//CREATE DATABASE IF NOT EXISTS  `ch6_cms` ;
		//GRANT ALL PRIVILEGES ON  `ch6_\cms` . * TO  'ch6_cms'@'localhost';
		'db' => array(
		  'class' => 'CDbConnection',
		  'connectionString' => 'mysql:host=127.0.0.1;dbname=ch6_cms',
		  'emulatePrepare' => true,
		  'username' => 'ch6_cms',
		  'password' => 'ch6_cms',
		  'charset' => 'utf8',
		  'schemaCachingDuration' => '3600',
		  'enableProfiling' => true,
		),

		'errorHandler'=>array(
		  'errorAction'=>'site/error',
    	),

		'urlManager' => array(
            'class'          => 'application.components.CMSUrlManager',
            'urlFormat'      => 'path',
            'showScriptName' => false
        ),

	     'log' => array(
	       'class' => 'CLogRouter',
	       'routes' => array(
	         array(
	           'class' => 'CWebLogRoute',
	           'levels' => 'error, warning, trace, info',
	           'enabled' => false
	         )
	       )
	     ),

    	'cache' => array(
      		'class' => 'CFileCache',
    	)
	),

	'params' => array(
		'includes' => require __DIR__ . '/params.php',
		'debug' => true,
		'trace' => 3
	)
);
