<?php
namespace Trojanbox\Framework;

use Trojanbox\Config\ArrayConfig;
use Trojanbox\File\File;
use Trojanbox\Exception\ErrorExceptionHandle;
use Trojanbox\Event\ListenerManager;
use Trojanbox\Event\EventManager;
use Trojanbox\Event\BehaviorListener;

require_once 'Framework.php';

/**
 * <b>创建一个Web应用程序，继承自 Framework。</b><br />
 * &nbsp;&nbsp;对 Framework 的一个集成，推荐使用 WebApplication 创建一个应用程序。<br />
 * &nbsp;&nbsp;如果尝试最大化自定义请使用 Framework 。<br />
 * &nbsp;&nbsp;self 尽会处理未被捕捉的NotFoundPage异常，所有的异常处理与错误处理都继承自 Exception 异常处理器。
 */
class WebApplication extends Framework {
	
	public function __construct() {
		
		defined('FRAMEWORK') === false ? define('FRAMEWORK', WORKSPACE . 'Trojanbox' . DIRECTORY_SEPARATOR) : '';
		
		spl_autoload_register(array($this, 'autoload'));
		ErrorExceptionHandle::setExceptionHandle();
		ErrorExceptionHandle::setErrorHandle();
		ErrorExceptionHandle::setFatalErrorHandle();
		
		parent::__construct();
		
		// 监听管理器和事件管理器
		$this->globals->listener = ListenerManager::getInstance();
		$this->globals->event = EventManager::getInstance();
		
		// 注册默认监听器
		$this->globals->listener->registerListener(new BehaviorListener('onBeginRequest'));
		$this->globals->listener->registerListener(new BehaviorListener('onEndRequest'));
		$this->globals->listener->registerListener(new BehaviorListener('onBeginDispatcher'));
		$this->globals->listener->registerListener(new BehaviorListener('onEndDispatcher'));
		
	}
	
	/**
	 * 执行
	 */
	public function run() {
		try {
			$this->letsGo();	// 执行
		} catch (\PageNotFoundException $e) {
			$config = new ArrayConfig(new File(WORKSPACE . 'System' . DS . 'Config' . DS . 'ExceptionTemplate.php'));
			$pageNotFound = $config->getConfig('page not found');
			$pageNotFound();
		}
	}
}