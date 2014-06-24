<?php
/**
 * 程序配置文件
 */
return array(
	'DATABASE' => array(
		'default' => array(
			'_TYPE' => 'Mysql',
			'HOST' => 'localhost',
			'DBNAME' => 'gh2',
			'USER' => 'root',
			'PWD' => '',
			'CHAR' => 'utf8',
		),
		'pdo' => array(
			'_TYPE' => 'Pdo',
			'DSN' => 'mysql:host=127.0.0.1;dbname=trojanbox',
			'USER' => 'root',
			'PWD' => '',
			'CHAR' => 'utf8',
		)
	),
	'ROUTE' => array(
		
	),
	'CACHE' => array(
		'_TYPE' => 'file',
		'time' => 1
	),
	'CACHE_HEPLER' => array(
		'_TYPE' => 'file',
		'time' => 60
	)
);