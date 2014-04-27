<?php
namespace Trojanbox\Framework;

/**
 * 全局控制文件
 * @author 权
 *
 */
class Framework {
	
	private $SelfObject = null;
	public $url = null;
	public $freameworkConfig = null;
	private $objectQueue;
	
	public function __construct() {
		include_once FRAMEWORK . 'Framework' . DIRECTORY_SEPARATOR . 'Exception.fun.php';	//加载错误控制器
		$this->activate();
	}
	
	/**
	 * 激活核心配置
	 * @return boolean
	 */
	public function activate() {
		//常量检查
		if (!is_dir(WORKSPACE)) throw new \Exception('工作空间(WORKSPACE)常量不存在，无法继续！');
		if (!is_dir(FRAMEWORK)) throw new \Exception('框架目录(FRAMEWORK)常量不存在，无法继续！');
		
		//创建新常量
		defined('APP_APPLICATION') === false ? define('APP_APPLICATION', WORKSPACE . 'Application' . DIRECTORY_SEPARATOR) : '';
		defined('APP_APPLICATION_CONFIG') === false ? define('APP_APPLICATION_CONFIG', WORKSPACE . 'Config' . DIRECTORY_SEPARATOR) : '';
		defined('APP_APPLICATION_CONTROLLER') === false ? define('APP_APPLICATION_CONTROLLER', APP_APPLICATION . 'Controller' . DIRECTORY_SEPARATOR) : '';
		defined('APP_APPLICATION_MODEL') === false ? define('APP_APPLICATION_MODEL', APP_APPLICATION . 'Model' . DIRECTORY_SEPARATOR) : '';
		defined('APP_APPLICATION_VIEW') === false ? define('APP_APPLICATION_VIEW', APP_APPLICATION . 'View' . DIRECTORY_SEPARATOR) : '';
		defined('WEB_APPLICATION_PUBLIC') === false ? define('WEB_APPLICATION_PUBLIC', 'http://' . $_SERVER['HTTP_HOST'] . '/Public/') : '';
		defined('WEB_APPLICATION') === false ? define('WEB_APPLICATION', 'http://' . $_SERVER['HTTP_HOST'] . '/') : '';
		defined('CACHE_FRAMEWORK') === false ? define('CACHE_FRAMEWORK', WORKSPACE . 'System' . DIRECTORY_SEPARATOR . 'FrameworkCache' . DIRECTORY_SEPARATOR) : '';
		spl_autoload_register(array($this, 'autoload'));
	}
	
	/**
	 * 对象自动加载
	 */
	public static function autoload($className) {
		$className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
		try {
			include_once WORKSPACE . $className . '.class.php';
		} catch (\Exception $e) {
			echo $e->getMessage();
			throw new \Exception('警告：骚年快离开这里！', 404);
		}
	}
	
	/**
	 * 对象注入
	 * @param unknown $object 有效对象
	 * @throws x\Exception
	 * @return \Trojanbox\Framework
	 */
	public function injectionObject($object) {
		if (!is_object($object)) throw new \Exception('这不是一个对象！');
		foreach ($this->objectQueue as $key => $value) $object->$key = $value;
		return $this;
	}
	
	/**
	 * 执行
	 * @throws \Trojanbox\Exception
	 */
	public function letsGo() {
		$this->freameworkConfig = \Trojanbox\Config\Loader::Factory('array')->setConfigFile('framework.php')->getConfig();
		//如果是路由对象则开启路由
		$route = \Trojanbox\Route\Loader::getInstance();
		if ($route->getState()) $requestUri = $route->setUrl($_SERVER['REQUEST_URI'])->getUrl();
		else $requestUri = $_SERVER['REQUEST_URI'];
		
		$requestUri = explode('/', $requestUri);
		$requestUri = \Trojanbox\Framework\Tools::clearArray($requestUri);
		$requestUriCount = count($requestUri);
		
		/** URL Fix */
		if ($requestUriCount == 2) {
			$requestUri[] = $this->freameworkConfig['DEFAULT_ACTION'];
		} elseif ($requestUriCount == 1) {
			$requestUri[] = $this->freameworkConfig['DEFAULT_CONTROLLER'];
			$requestUri[] = $this->freameworkConfig['DEFAULT_ACTION'];
		} elseif ($requestUriCount == 0) {
			$requestUri[] = $this->freameworkConfig['DEFAULT_GROUP'];
			$requestUri[] = $this->freameworkConfig['DEFAULT_CONTROLLER'];
			$requestUri[] = $this->freameworkConfig['DEFAULT_ACTION'];
		}
		
		/** URL Manager */
		/** Framework Group Controller Action */
		$url['_core_']['framework']['group'] = ucfirst($requestUri[0]);
		$url['_core_']['framework']['controller'] = ucfirst($requestUri[1]) . 'Controller.class.php';
		$url['_core_']['framework']['action'] = $requestUri[2] . 'Action';
		
		$url['_core_']['all'][] = ucfirst($requestUri[0]);
		$url['_core_']['all'][] = ucfirst($requestUri[1]);
		$url['_core_']['all'][] = $requestUri[2];
		
		unset($requestUri[0], $requestUri[1], $requestUri[2]);
		$requestUri = array_merge($requestUri);
		
		$requestUriCountH = count($requestUri);
		if ($requestUriCountH % 2 == 1) $requestUri[] = 0;
		if (empty($requestUri)) goto redirect;
			foreach ($requestUri as $value) $url['_core_']['all'][] = $url['_core_']['uri'][] = $value;
			$urlCoreUriCount = count($url['_core_']['uri']);
			for ($i = 0; $i < $urlCoreUriCount; $i+=2) $url[$url['_core_']['uri'][$i]] = $url['_core_']['uri'][$i+1];
		redirect:	//goto there
		$tmp = $url['_core_'];
		unset($url['_core_']);
		$_GET = $url['_core_'] = $tmp;
		$this->url = $url;
		
		//注册GETPOST方法到全局变量
		\Trojanbox\Globals\Loader::getInstance()->set('get', $this->url)->set('post', $_POST);
		$this->adapter();
	}
	
	/**
	 * 适配器
	 * @throws \Trojanbox\Exception
	 */
	final protected function adapter() {
		$publicHtml = 'Wctmlgb 页面不存在？';
		$this->ErrorTemplateConfig = \Trojanbox\Config\Loader::Factory('array')
			->setConfigFile('ErrorTemplate.php')
			->getConfig();
		try {
			if (!is_file(APP_APPLICATION_CONTROLLER . $this->url['_core_']['all'][0] . DIRECTORY_SEPARATOR . $this->url['_core_']['all'][1] . 'Controller.class.php')) throw new \Exception($publicHtml, 404);
			$controllerName = '\\Application\\Controller\\' . $this->url['_core_']['all'][0] . '\\' . $this->url['_core_']['all'][1].'Controller';
			if (class_exists($controllerName)) {
				$controller = new \ReflectionClass($controllerName);
				if ($controller->hasMethod($this->url['_core_']['framework']['action'])) {
					$controllerInstance = $controller->newInstance();
					$method = $controller->getMethod($this->url['_core_']['framework']['action']);
					$method->invoke($controllerInstance);
				} else throw new \Exception($publicHtml, '404');
			} else throw new \Exception($publicHtml, '404');
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}