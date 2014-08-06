<?php
/**
 * TrojanBox Framework - 写的更多，做的更少
 * @import Com\Trojanbox
 * @author 王权
 * @see www.trojanbox.com
 */
use Trojanbox\WebApplication;

header('Content-type: text/html; charset=UTF-8');
date_default_timezone_set('Asia/Shanghai');

session_start();

define('DS', DIRECTORY_SEPARATOR);
define('WORKSPACE', __DIR__ . DS);
include WORKSPACE . 'Framework' . DS . 'Trojanbox' . DS . 'WebApplication.php';

$app = new WebApplication();
$app->bootstrap(function ($app) {
    // 全局引导文件
    // 优先级最高。在这之前框架仅加载了一些必要的类。
});
$app->run();