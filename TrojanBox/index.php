<?php
/**
 * TrojanBox Framework - 写的更多，做的更少
 * @import com.trojanbox
 * @author 权
 */

namespace Torjanbox;

header('Content-type: text/html; charset=UTF-8');
date_default_timezone_set('Asia/Shanghai');
session_start();

//当前目录 - 必备常量
defined('WORKSPACE') === false ? define('WORKSPACE', dirname(__FILE__) . DIRECTORY_SEPARATOR) : '';
defined('FRAMEWORK') === false ? define('FRAMEWORK', WORKSPACE . 'Trojanbox' . DIRECTORY_SEPARATOR) : '';

//载入框架核心
include_once FRAMEWORK . 'Framework' . DIRECTORY_SEPARATOR . 'Framework.core.php';

$framework = new \Trojanbox\Framework\Framework();

//取得配置文件信息
$config = \Trojanbox\Config\Loader::Factory('array')->setConfigFile('config.php');

//注册到全局对象
$globals = \Trojanbox\Globals\Loader::getInstance();
$globals->set('sql', \Trojanbox\Db\Loader::Factory($config->getConfig()['DATABASE']['pdo']), 'MV')
		->set('cache', \Trojanbox\Cache\Loader::Factory($config->getConfig()['CACHE']))
		->set('config' ,$config);

//启动路由
\Trojanbox\Route\Loader::getInstance($config->getConfig()['ROUTE']);	//启用路由

$framework->letsGo();	//执行
