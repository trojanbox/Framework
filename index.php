<?php
/**
 * TrojanBox Framework - 写的更多，做的更少
 * @import Com\Trojanbox
 * @author 王权
 * @see www.trojanbox.com
 */

use Trojanbox\Framework\WebApplication;
use Application\Event\LoaderEvent;
use Trojanbox\Di\DiManager;
use Trojanbox\Di\DiConfig;

header('Content-type: text/html; charset=UTF-8');
date_default_timezone_set('Asia/Shanghai');

session_start();

// 当前目录 - 必备常量
define('WORKSPACE', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('FRAMEWORK', WORKSPACE . 'Framework' . DIRECTORY_SEPARATOR);

include 'Framework' . DIRECTORY_SEPARATOR . 'Trojanbox' . DIRECTORY_SEPARATOR . 'Framework' . DIRECTORY_SEPARATOR . 'WebApplication.php';
include 'Framework' . DIRECTORY_SEPARATOR . 'Vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$app = new WebApplication();

// 注册加载事件
$app->globals->listener->onBeginRequest->addEventHandle(new LoaderEvent('LoaderEvent'));
$config = include WORKSPACE . 'System' . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'DiConfig.php';

$diConfig = DiConfig::of(new DiManager(), $config);
$diConfig->di->capsule;

$app->run();