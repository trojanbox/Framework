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

// 当前目录 - 必备常量
define('WORKSPACE', __DIR__ . DIRECTORY_SEPARATOR);
include WORKSPACE . 'Framework' . DIRECTORY_SEPARATOR . 'Trojanbox' . DIRECTORY_SEPARATOR . 'WebApplication.php';

$app = new WebApplication();
$app->bootstrap()->run();