<?php

use Trojanbox\Framework\WebApplication;
use Trojanbox\Package\PackageManager;

/**
 * TrojanBox Framework - 写的更多，做的更少
 * @import com.trojanbox
 * @author 权
 * @see www.trojanbox.com
 */

header('Content-type: text/html; charset=UTF-8');
date_default_timezone_set('Asia/Shanghai');

session_start();

include '/Trojanbox/Framework/WebApplication.php';

// 当前目录 - 必备常量
defined('WORKSPACE') === false ? define('WORKSPACE', dirname(__FILE__) . DIRECTORY_SEPARATOR) : '';
defined('FRAMEWORK') === false ? define('FRAMEWORK', WORKSPACE . 'Trojanbox' . DIRECTORY_SEPARATOR) : '';

$webApplication = new WebApplication();

$webApplication->setExtend(function ($web) {
	
	// 自动加载所有包
	PackageManager::setAutoLoad(true);
	
	/*
	$c = new CreateExtendPackage('com-trojanbox-util-page-basicpage', WORKSPACE . 'Extend');
	$c->setAuthor('TrojanBox');
	$c->setDescription('分页类');
	$c->setSee('http://www.trojanbox.com');
	$c->setVersion('1.0');
	$c->uppack();
	*/
	
});

$webApplication->run();
