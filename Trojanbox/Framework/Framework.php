<?php
namespace Trojanbox\Framework;

use Trojanbox\Framework\ApplicationErrorException;
use Trojanbox\Framework\Exception\ClassNotFoundException;
use Trojanbox\Framework\Exception\ActionNotFoundException;
use Trojanbox\Framework\Exception\ControllerNotFoundException;
use Trojanbox\Framework\Exception\GroupNotFoundException;
use Trojanbox\Framework\Exception\FrameworkException;
use Trojanbox\Route\Route;
use Trojanbox\Globals\Globals;
use Trojanbox\Config\ArrayConfig;
use Trojanbox\File\File;
use Trojanbox\File\Exception\FileNotFoundException;
use Trojanbox\EventManager\EventManager;
use Trojanbox\EventManager\EventListener;
use Trojanbox\Package\PackageManager;

/**
 * 全局控制文件
 * @author 权
 *
 */
class Framework {
	
	public $url = null;
	
	/** 系统 监听器 */
	private $SystemFrameworkEvent = null;
	
	/** 路由 监听器 */
	private $RouteNamespaceControllerEvent = null;
	private $RouteNamespaceControllerActionEvent = null;
	
	/**
	 * 框架规则配置文件
	 * @var unknown
	 */
	public $frameworkConfig = array(
		'DEFAULT_CONTROLLER' => 'Index',
		'DEFAULT_ACTION' => 'index',
	);
	
	public function __construct() {
		
		// 注册自动加载
		spl_autoload_register(array($this, 'autoload'));
		
		// 设置错误处理器
		set_error_handler(function ($errno, $errstr, $errfile, $errline) {
			if (error_reporting() == 0) return ;
			throw new ApplicationErrorException($errstr, 0, $errno, $errfile, $errline);
		}, E_ALL);
		
		$this->activate()->eventRegister();
		
		$this->SystemFrameworkEvent->setHook('Start');
		
		// 包管理器
		PackageManager::getInstace()->loadPackage();
	}
	
	/**
	 * 注册事件监听器
	 */
	public function eventRegister() {
		
		// 事件驱动管理
		try {
			$eventDrivenConfig = new ArrayConfig(new File(WORKSPACE . 'System' . DS . 'Config' . DS . 'EventDriven.php'));
			$eventLinstenerConfig = new ArrayConfig(new File(WORKSPACE . 'System' . DS . 'Config' . DS . 'EventListener.php'));
				
			Globals::getInstance()->set('EventDriven', $eventDrivenConfig->getConfigAll());
			Globals::getInstance()->set('EventListener', $eventLinstenerConfig->getConfigAll());
				
			$eventManager = EventManager::getInstance(Globals::getInstance()->EventDriven);
			$eventLinstener = new EventListener(Globals::getInstance()->EventListener);
			$eventLinstener->setEventManager($eventManager);
				
			Globals::getInstance()->set('SystemEventListener', $eventLinstener);
				
			EventManager::$state = true;
				
		} catch (FileNotFoundException $e) {
			EventManager::$state = false;
		}
		
		// 注册钩子
		if (EventManager::$state) $this->SystemFrameworkEvent = $eventLinstener->listen('SystemFramework');
	}
	
	/**
	 * 激活核心配置
	 * @return boolean
	 */
	public function activate() {
		
		//常量检查
		if (!is_dir(WORKSPACE)) {
			throw new FrameworkException('工作空间(WORKSPACE)常量不存在，无法继续！');
		}
		if (!is_dir(FRAMEWORK)) {
			throw new FrameworkException('框架目录(FRAMEWORK)常量不存在，无法继续！');
		}
		
		//创建新常量
		defined('DS') === false ? define('DS', DIRECTORY_SEPARATOR) : '';
		defined('APP_APPLICATION') === false ? define('APP_APPLICATION', WORKSPACE . 'Application' . DS) : '';
		defined('APP_PACKAGE') === false ? define('APP_PACKAGE', WORKSPACE . 'Package' . DS) : '';
		defined('APP_APPLICATION_CONFIG') === false ? define('APP_APPLICATION_CONFIG', WORKSPACE . 'Config' . DS) : '';
		defined('APP_APPLICATION_CONTROLLER') === false ? define('APP_APPLICATION_CONTROLLER', APP_APPLICATION . 'Controller' . DS) : '';
		defined('APP_APPLICATION_MODEL') === false ? define('APP_APPLICATION_MODEL', APP_APPLICATION . 'Model' . DS) : '';
		defined('APP_APPLICATION_VIEW') === false ? define('APP_APPLICATION_VIEW', APP_APPLICATION . 'View' . DS) : '';
		defined('WEB_APPLICATION_PUBLIC') === false ? define('WEB_APPLICATION_PUBLIC', 'http://' . $_SERVER['HTTP_HOST'] . '/Public/') : '';
		defined('WEB_APPLICATION') === false ? define('WEB_APPLICATION', 'http://' . $_SERVER['HTTP_HOST'] . '/') : '';
		defined('CACHE_FRAMEWORK') === false ? define('CACHE_FRAMEWORK', WORKSPACE . 'System' . DS . 'FrameworkCache' . DS) : '';

		return $this;
	}
	
	/**
	 * 对象自动加载
	 */
	public static function autoload($className) {
		$className = str_replace('\\', DS, $className);
		if (is_file(WORKSPACE . $className . '.php')) {
			include_once WORKSPACE . $className . '.php';
			return ;
		}

		if (is_file(WORKSPACE . 'Extend' . DS . $className . '.php')) {
			include_once WORKSPACE . 'Extend' . DS . $className . '.php';
			return ;
		} 

		if (false !== ($sourceInfo = PackageManager::getInstace()->getSource('\\' . $className))) {
			$package = 'phar://' . APP_PACKAGE . $sourceInfo['directory'] . DS . $sourceInfo['package_name'] . '\\' . $className . '.php';
			include $package;
			return ;
		}
		
		throw new ClassNotFoundException('ClassNotFound ' . $className . '!');
	}
	
	/**
	 * 执行
	 * @throws \Trojanbox\Exception
	 */
	public function letsGo() {
		
		$routeArray = new ArrayConfig(new File(WORKSPACE . 'System' . DS . 'Config' . DS . 'Config.php'));
		
		//如果是路由对象则开启路由
		$route = Route::getInstance($routeArray->getConfig('ROUTE'));
		if ($route->getState()) {
			$requestUri = $route->setUrl($_SERVER['REQUEST_URI'])->getUrl();
		} else {
			$requestUri = $_SERVER['REQUEST_URI'];
		}

		// URL 处理
		$requestUri = str_replace(array('/?'), '?', $requestUri);
		$requestUriString = $requestUri;
		$requestUri = array_merge(array_filter(explode('/', $requestUri)));
		$requestUriCount = count($requestUri);
		
		// URI 处理
		$actiontmp = explode('?', $requestUriString);
		if (empty($actiontmp[0])) {
			unset($requestUri[$requestUriCount-1]);
			$requestUriCount = count($requestUri);
		}

		// 默认值检查
		if ($requestUriCount <= 0) {
			array_unshift($requestUri, $this->frameworkConfig['DEFAULT_CONTROLLER'], $this->frameworkConfig['DEFAULT_ACTION']);
		} else if ($requestUriCount == 1) {
			array_unshift($requestUri, $this->frameworkConfig['DEFAULT_ACTION']);
		}
		
		$requestUriCount = count($requestUri);
		
		// 获取目录
		$tmp = $requestUri;
		for ($i = $requestUriCount-2; $i <= $requestUriCount; $i++) {
			unset($tmp[$i]);
		}
		$directory = implode(DS, $tmp);
		if (!empty($directory)) {
			$urlController['directory'] = $directory . DS;
		} else {
			$urlController['directory'] = '';
		}
		
		unset($tmp);
		
		// 获取控制器
		$urlController['controller'] = $requestUri[$requestUriCount-2];
		
		// 获取方法
		$urlController['action'] = $requestUri[$requestUriCount-1];
		
		//注册GETPOST方法到全局变量
		Globals::getInstance()->set('HttpRequestArgs', $urlController)->set('get', $_GET)->set('post', $_POST);
		
		$this->dispatcher();
		
		$this->SystemFrameworkEvent->setHook('End');
	}
	
	/**
	 * Web 应用程序分发器
	 * @throws GroupNotFoundException
	 * @throws ControllerNotFoundException
	 * @throws ActionNotFoundException
	 */
	final protected function dispatcher() {
		
		// 钩子监听器
		$eventLinstener = Globals::getInstance()->SystemEventListener;
		$httpRequestArgs = Globals::getInstance()->HttpRequestArgs;

		$directory = APP_APPLICATION_CONTROLLER . $httpRequestArgs['directory'];
		$controller = 'Application\\Controller\\' . $httpRequestArgs['directory'] . ucfirst($httpRequestArgs['controller']) . 'Controller';
		$action = $httpRequestArgs['action'] . 'Action';

		// 注册事件监听
		if (EventManager::$state) {
			$this->RouteNamespaceControllerEvent = $eventLinstener->listen($controller);
			$this->RouteNamespaceControllerActionEvent = $eventLinstener->listen($controller . '::' . $action);
		}
		// 目录检查
		if (!is_dir($directory)) {
			throw new GroupNotFoundException('No Found Group ' . $httpRequestArgs['directory'] . '!');
		}
		
		// 对象检查
		if (!class_exists($controller)) {
			throw new ControllerNotFoundException('No Found Controller ' . $controller . '!');
		}
		
		$this->RouteNamespaceControllerEvent->setHook('Before');
		$controllerInstance = new $controller();
		
		// 方法检查
		if (!method_exists($controllerInstance, $action)) {
			throw new ActionNotFoundException('No Found Action ' . $action . '!');
		}
		
		$this->RouteNamespaceControllerActionEvent->setHook('Before');
		$controllerInstance->$action();
		$this->RouteNamespaceControllerActionEvent->setHook('After');
		$this->RouteNamespaceControllerEvent->setHook('After');
	}

}
