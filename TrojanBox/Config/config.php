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
			'DSN' => 'mysql:host=localhost;dbname=trojanbox',
			'USER' => 'root',
			'PWD' => '',
			'CHAR' => 'utf8',
			'SQLFilter' => \Trojanbox\Tools\Loader::factory(array('_TYPE' => 'SQLFilter')),	//SQL注入过滤�?
		)
	),
	'ROUTE' => array(
		'/^\/$/i' => '/Home/Index/index',
		'/^\/admin(.*)/i' => '/Admin/$1',
		'/^\/show\/(\d+).html$/i' => '/Home/Index/show/id/$1',
		'/^\/lists\/0-(\d+).html$/i' => '/Home/Index/index/page/$1',
		'/^\/lists\/(\d+).html$/i' => '/Home/Index/lists/id/$1',
		'/^\/lists\/(\d+)-(\d+).html$/i' => '/Home/Index/lists/id/$1/page/$2',
		'/^\/home\/comment\/(.*)/i' => '/home/comment/$1',
		'/.*/i' => '/error/template/faf',
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