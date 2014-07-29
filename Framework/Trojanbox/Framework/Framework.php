<?php
namespace Trojanbox\Framework;

use Trojanbox\Framework\Route;
use Trojanbox\Framework\Globals;
use Trojanbox\Config\ArrayConfig;
use Trojanbox\File\File;
use Trojanbox\Package\PackageManager;
use Trojanbox\Event\EventManager;
use Trojanbox\Event\ListenerManager;
use Trojanbox\Event\BehaviorListener;

/**
 * 全局控制文件
 * 
 * @author 权
 *        
 */
class Framework
{

    public $globals = null;

    /**
     * 框架规则配置文件
     * 
     * @var unknown
     */
    public $frameworkConfig = array(
        'DEFAULT_CONTROLLER' => 'Index',
        'DEFAULT_ACTION' => 'index'
    );

    public function __construct()
    {
        if (is_file(FRAMEWORK . 'Vendor' . DIRECTORY_SEPARATOR . 'autoload.php')) {
            include FRAMEWORK . 'Vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
        }
        
        $this->globals = Globals::getInstance();
        
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
     * 激活核心配置
     * 
     * @return boolean
     */
    public function activate()
    {
        
        // 常量检查
        if (! is_dir(WORKSPACE)) {
            throw new \FrameworkException('Can not find constant WORKSPACE.');
        }
        if (! is_dir(FRAMEWORK)) {
            throw new \FrameworkException('Can not find constant FRAMEWORK.');
        }
        
        defined('DS') === false ? define('DS', DIRECTORY_SEPARATOR) : '';
        defined('APP_APPLICATION') === false ? define('APP_APPLICATION', WORKSPACE . 'Application' . DS) : '';
        defined('APP_PACKAGE') === false ? define('APP_PACKAGE', WORKSPACE . 'Package' . DS) : '';
        defined('APP_APPLICATION_CONFIG') === false ? define('APP_APPLICATION_CONFIG', WORKSPACE . 'Config' . DS) : '';
        defined('APP_APPLICATION_EXTEND') === false ? define('APP_APPLICATION_EXTEND', WORKSPACE . 'Extend' . DS) : '';
        defined('APP_APPLICATION_CONTROLLER') === false ? define('APP_APPLICATION_CONTROLLER', APP_APPLICATION . 'Controller' . DS) : '';
        defined('APP_APPLICATION_MODEL') === false ? define('APP_APPLICATION_MODEL', APP_APPLICATION . 'Model' . DS) : '';
        defined('APP_APPLICATION_VIEW') === false ? define('APP_APPLICATION_VIEW', APP_APPLICATION . 'View' . DS) : '';
        defined('WEB_APPLICATION_PUBLIC') === false ? define('WEB_APPLICATION_PUBLIC', 'http://' . $_SERVER['HTTP_HOST'] . '/Public/') : '';
        defined('WEB_APPLICATION') === false ? define('WEB_APPLICATION', 'http://' . $_SERVER['HTTP_HOST'] . '/') : '';
        defined('CACHE_FRAMEWORK') === false ? define('CACHE_FRAMEWORK', WORKSPACE . 'System' . DS . 'FrameworkCache' . DS) : '';
        
        if ($this->globals->listener->hasListener('onBeginRequest')) {
            $this->globals->listener->onBeginRequest->monitor();
        }
        
        ExtendClassLoader::setExtendDir(APP_APPLICATION_EXTEND);
        PackageManager::getInstace()->loadPackage();
        
        return $this;
    }

    /**
     * 对象自动加载
     */
    public static function autoload($className)
    {
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        
        if (is_file(FRAMEWORK . $className . '.php')) {
            include_once FRAMEWORK . $className . '.php';
        } if (is_file(WORKSPACE . $className . '.php')) {
            include_once WORKSPACE . $className . '.php';
        } elseif (is_file(FRAMEWORK . 'Extend' . DIRECTORY_SEPARATOR . $className . '.php')) {
            include_once FRAMEWORK . 'Extend' . DIRECTORY_SEPARATOR . $className . '.php';
        } elseif (false !== ($sourceInfo = PackageManager::getInstace()->getSource('\\' . $className))) {
            $package = 'phar://' . APP_PACKAGE . $sourceInfo['directory'] . DIRECTORY_SEPARATOR . $sourceInfo['package_name'] . '\\' . $className . '.php';
            include $package;
        }
    }

    /**
     * 执行
     * 
     * @throws \Trojanbox\Exception
     */
    public function letsGo()
    {
        $routeArray = new ArrayConfig(new File(WORKSPACE . 'System' . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'Config.php'));
        
        // 如果是路由对象则开启路由
        $route = Route::getInstance($routeArray->getConfig('ROUTE'));
        if ($route->getState()) {
            $requestUri = $route->setUrl($_SERVER['REQUEST_URI'])->getUrl();
        } else {
            $requestUri = $_SERVER['REQUEST_URI'];
        }
        
        // URL 处理
        $requestUri = str_replace(array(
            '/?'
        ), '?', $requestUri);
        $tmp = explode('?', $requestUri);
        $requestUri = $tmp[0];
        $requestUriString = $requestUri;
        $requestUri = array_merge(array_filter(explode('/', $requestUri)));
        $requestUriCount = count($requestUri);
        
        // URI 处理
        $actiontmp = explode('?', $requestUriString);
        if (empty($actiontmp[0])) {
            unset($requestUri[$requestUriCount - 1]);
            $requestUriCount = count($requestUri);
        }
        
        // 默认值检查
        if ($requestUriCount <= 0) {
            array_unshift($requestUri, $this->frameworkConfig['DEFAULT_CONTROLLER'], $this->frameworkConfig['DEFAULT_ACTION']);
        } else 
            if ($requestUriCount == 1) {
                array_unshift($requestUri, $this->frameworkConfig['DEFAULT_ACTION']);
            }
        
        $requestUriCount = count($requestUri);
        
        // 获取目录
        $tmp = $requestUri;
        for ($i = $requestUriCount - 2; $i <= $requestUriCount; $i ++) {
            unset($tmp[$i]);
        }
        $directory = implode(DIRECTORY_SEPARATOR, $tmp);
        if (! empty($directory)) {
            $urlController['directory'] = $directory . '/';
        } else {
            $urlController['directory'] = '';
        }
        
        unset($tmp);
        
        // 获取控制器
        $urlController['controller'] = $requestUri[$requestUriCount - 2];
        
        // 获取方法
        $urlController['action'] = $requestUri[$requestUriCount - 1];
        
        // 注册GETPOST方法到全局变量
        Globals::getInstance()->set('HttpRequestArgs', $urlController)
            ->set('get', $_GET)
            ->set('post', $_POST);
        
        $this->dispatcher();
    }

    /**
     * Web 应用程序分发器
     * 
     * @throws GroupNotFoundException
     * @throws ControllerNotFoundException
     * @throws ActionNotFoundException
     */
    final protected function dispatcher()
    {
        $httpRequestArgs = $this->globals->HttpRequestArgs;
        
        if ($this->globals->listener->hasListener('onBeginDispatcher')) {
            $this->globals->listener->onBeginDispatcher->monitor();
        }
        
        $directory = APP_APPLICATION_CONTROLLER . $httpRequestArgs['directory'];
        $controller = 'Application\\Controller\\' . str_replace(DIRECTORY_SEPARATOR, '\\', $httpRequestArgs['directory']) . ucfirst($httpRequestArgs['controller']) . 'Controller';
        $action = $httpRequestArgs['action'] . 'Action';
        
        // 目录检查
        if (! is_dir($directory)) {
            throw new \DirectoryNotFoundException('No Found Group ' . $httpRequestArgs['directory'] . '!');
        }
        
        // 对象检查
        if (! class_exists($controller)) {
            throw new \ClassNotFoundException('No Found Controller ' . $controller . '!');
        }
        
        $controllerInstance = new $controller();
        
        // 方法检查
        if (! method_exists($controllerInstance, $action)) {
            throw new \NoSuchMethodException('No Found Action ' . $action . '!');
        }
        
        if ($this->globals->listener->hasListener('onEndDispatcher')) {
            $this->globals->listener->onEndDispatcher->monitor();
        }
        
        $controllerInstance->$action();
        
        if ($this->globals->listener->hasListener('onEndRequest')) {
            $this->globals->listener->onEndRequest->monitor();
        }
    }
}
