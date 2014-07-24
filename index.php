<?php
/**
 * TrojanBox Framework - 写的更多，做的更少
 * @import Com\Trojanbox
 * @author 王权
 * @see www.trojanbox.com
 */

use Trojanbox\Framework\WebApplication;
use Application\Event\LoaderEvent;
use Trojanbox\Di\Di;

header('Content-type: text/html; charset=UTF-8');
date_default_timezone_set('Asia/Shanghai');

session_start();

include 'Trojanbox/Framework/WebApplication.php';

// 当前目录 - 必备常量
define('WORKSPACE', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('FRAMEWORK', WORKSPACE . 'Trojanbox' . DIRECTORY_SEPARATOR);

$app = new WebApplication();

// 注册加载事件
$app->globals->listener->onBeginRequest->addEventHandle(new LoaderEvent('LoaderEvent'));

$di = new Di();
$di->set('test', '\\Application\\Engine\\DefaultEngine');
$object = $di->get('test');

$app->run();