<?php
namespace Trojanbox\Framework;

use Trojanbox\Package\PackageManager;
use Trojanbox\Event\EventManager;
use Trojanbox\Event\ListenerManager;
use Trojanbox\Event\BehaviorListener;
use Trojanbox\Di\ServiceLocator;
use Trojanbox\Framework\FrameworkInterface\DispatcherInterface;
include 'AutoLoader.php';

/**
 * 全局控制文件
 *
 * @author 权
 *        
 */
class Framework
{
    protected $dispatcher = null;
    
    /**
     * 设置分发器
     * 
     * @param DispatcherInterface $dispatcher
     */
    public function setDispatcher(DispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function setDefine()
    {
        if (! is_dir(WORKSPACE)) {
            throw new \FrameworkException('Can not find constant WORKSPACE.');
        }
        if (! is_dir(FRAMEWORK)) {
            throw new \FrameworkException('Can not find constant FRAMEWORK.');
        }
        
        defined('DS') === false ? define('DS', DIRECTORY_SEPARATOR) : '';
        defined('APP_MODULE') === false ? define('APP_MODULE', WORKSPACE . 'Module' . DS) : '';
        defined('APP_PACKAGE') === false ? define('APP_PACKAGE', WORKSPACE . 'Package' . DS) : '';
        defined('APP_EXTEND') === false ? define('APP_EXTEND', WORKSPACE . 'Extend' . DS) : '';
        defined('WEB_APPLICATION_PUBLIC') === false ? define('WEB_APPLICATION_PUBLIC', 'http://' . $_SERVER['HTTP_HOST'] . '/Public/') : '';
        defined('WEB_APPLICATION') === false ? define('WEB_APPLICATION', 'http://' . $_SERVER['HTTP_HOST'] . '/') : '';
        defined('CACHE_FRAMEWORK') === false ? define('CACHE_FRAMEWORK', WORKSPACE . 'System' . DS . 'FrameworkCache' . DS) : '';
    }
    
    public function __construct()
    {
        if (is_file(FRAMEWORK . 'Vendor' . DIRECTORY_SEPARATOR . 'autoload.php')) {
            include FRAMEWORK . 'Vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
        }

        ServiceLocator::register('listener', ListenerManager::getInstance());
        ServiceLocator::register('event', EventManager::getInstance());

        ServiceLocator::listener()->registerListener(new BehaviorListener('onBeginRequest'));
        ServiceLocator::listener()->registerListener(new BehaviorListener('onEndRequest'));
        ServiceLocator::listener()->registerListener(new BehaviorListener('onBeginDispatcher'));
        ServiceLocator::listener()->registerListener(new BehaviorListener('onEndDispatcher'));
    }

    /**
     * 激活核心配置
     *
     * @return boolean
     */
    public function activate()
    {
        if (ServiceLocator::listener()->hasListener('onBeginRequest')) {
            ServiceLocator::listener()->onBeginRequest->monitor();
        }
        
        LoaderClass::setExtendDir(APP_EXTEND);
        PackageManager::getInstace()->loadPackage();
        
        return $this;
    }

    /**
     * 执行
     *
     * @throws \Trojanbox\Exception
     */
    public function letsGo()
    {
        $dispatcher = new Dispatcher();
        $dispatcher->setRequestUri($_SERVER['REQUEST_URI']);
        $dispatcher->run();
        $dispatcher->dispatcher();
        
    }
}
