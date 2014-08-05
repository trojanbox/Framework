<?php
namespace Trojanbox\Framework;

use Trojanbox\Framework\FrameworkInterface\DispatcherInterface;
use Trojanbox\Framework\Exception\DispatcherException;
use Trojanbox\Di\ServiceLocator;

class Dispatcher implements DispatcherInterface
{

    protected $requestUri = null;
    
    protected $route = null;

    /**
     * 设置URI
     * 
     * @param string $uri
     * @throws DispatcherException
     */
    public function setRequestUri($uri)
    {
        if (! is_string($uri))
            throw new DispatcherException('Type error String.', E_ERROR);
        $this->requestUri = $uri;
    }
    
    /**
     * 设置路由
     * 
     * @param \Trojanbox\Route\RouteInterface\DispatcherInterface $route
     */
    public function setRoute(\Trojanbox\Route\RouteInterface\DispatcherInterface $route)
    {
    	$this->route = $route;
    }
    
    /**
     * 执行
     */
    public function run()
    {
        
        $defaultDispatcher = Config::loader('System.Config', 'default_dispatcher');

        $requestUri = $_SERVER['REQUEST_URI'];
        $requestUri = str_replace(array(
            '/?'
        ), '?', $requestUri);
        $tmp = explode('?', $requestUri);
        $requestUri = $tmp[0];
        $requestUriString = $requestUri;
        $requestUri = array_merge(array_filter(explode('/', $requestUri)));
        $requestUriCount = count($requestUri);
        $actiontmp = explode('?', $requestUriString);
        if (empty($actiontmp[0])) {
            unset($requestUri[$requestUriCount - 1]);
            $requestUriCount = count($requestUri);
        }

        // FIXED
        if ($requestUriCount <= 0) {
            array_unshift($requestUri, $defaultDispatcher['module'], $defaultDispatcher['controller'], $defaultDispatcher['action']);
        } else if ($requestUriCount == 1) {
            array_unshift($requestUri, $defaultDispatcher['module'], $defaultDispatcher['controller']);
        } else if ($requestUriCount == 2) {
            array_unshift($requestUri, $defaultDispatcher['module']);
        }

        $requestUritmp = $requestUri;
        
        // get module
        $module = ucfirst($requestUritmp[0]);
        unset($requestUritmp[0]);
        $requestUritmp = array_merge($requestUritmp);
        
        // get action
        $actionTmpCount = count($requestUritmp)-1;
        $action = $requestUritmp[$actionTmpCount];
        unset($requestUritmp[$actionTmpCount]);
        $requestUritmp = array_merge($requestUritmp);
        
        // get controller
        $controllerTmpCount = count($requestUritmp)-1;
        $controller = ucfirst($requestUritmp[$controllerTmpCount]);
        unset($requestUritmp[$controllerTmpCount]);
        $requestUritmp = array_merge($requestUritmp);

        $directory = implode(DS, $requestUritmp);
        if (! empty($directory)) 
            $directory .= DS;

        unset($requestUritmp);
        
        $urlController['module'] = $module;
        $urlController['directory'] = $directory;
        $urlController['controller'] = $controller;
        $urlController['action'] = $action;
        ServiceLocator::register('httpRequestArgs', $urlController);
    }
    
    /**
     * 分发器
     *
     * @throws GroupNotFoundException
     * @throws ControllerNotFoundException
     * @throws ActionNotFoundException
     */
    final public function dispatcher()
    {
        $httpRequestArgs = ServiceLocator::httpRequestArgs();
    
        if (ServiceLocator::listener()->hasListener('onBeginDispatcher')) {
            ServiceLocator::listener()->onBeginDispatcher->monitor();
        }
    
        $directory = APP_MODULE . $httpRequestArgs['module'] . DS . 'Controller' . DS . $httpRequestArgs['directory'];
        $controller = $httpRequestArgs['module'] . '\\Controller\\' . str_replace(DIRECTORY_SEPARATOR, '\\', $httpRequestArgs['directory']) . $httpRequestArgs['controller'] . 'Controller';
        $action = $httpRequestArgs['action'] . 'Action';

        if (! is_dir($directory)) {
            throw new \DirectoryNotFoundException('No Found Group ' . $httpRequestArgs['directory'] . '!');
        }
    
        if (! class_exists($controller)) {
            throw new \ClassNotFoundException('No Found Controller ' . $controller . '!');
        }
    
        $controllerInstance = new $controller();
    
        if (! method_exists($controllerInstance, $action)) {
            throw new \NoSuchMethodException('No Found Action ' . $action . '!');
        }
    
        if (ServiceLocator::listener()->hasListener('onEndDispatcher')) {
            ServiceLocator::listener()->onEndDispatcher->monitor();
        }

        $controllerInstance->$action();
    
        if (ServiceLocator::listener()->hasListener('onEndRequest')) {
            ServiceLocator::listener()->onEndRequest->monitor();
        }
    }
}