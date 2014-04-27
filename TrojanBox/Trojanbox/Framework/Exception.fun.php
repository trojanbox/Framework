<?php
namespace Trojanbox\Framework;

/**
 * 异常错误触发器
 * @param unknown $e
 */
function ExceptionFunction($exception) {
	$config = \Trojanbox\Config\Loader::Factory('array')->setConfigFile('ErrorTemplate.php')->getConfig();
	$config[$exception->getCode()]($exception);
}

/**
 * 错误控制器
 * @param unknown $errno
 * @param unknown $errstr
 * @param unknown $errfile
 * @param unknown $errline
 * @throws \ErrorException
 */
function ExceptionErrorHandler($errno, $errstr, $errfile, $errline) {
	throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
}

set_error_handler('\Trojanbox\Framework\ExceptionErrorHandler', E_ALL);
set_exception_handler('\Trojanbox\Framework\ExceptionFunction');
