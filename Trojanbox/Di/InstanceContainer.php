<?php
namespace Trojanbox\Di;

use Trojanbox\Di\DiInterface\ContainerInterface;

class InstanceContainer implements ContainerInterface
{

    private $container = array();
    
    private $di = null;

    public function __construct(Di $di)
    {
        $this->di = $di;
    }
    
    /**
     * 检查这个实例是否存在
     * 
     * @param string $alias
     * @return boolean
     */
    public function hasInstance($alias)
    {
    	return array_key_exists($alias, $this->container);
    }
    
    /**
     * 取得实例
     * 
     * @param string $alias
     * @return array
     */
    public function getInstance($alias)
    {
        return $this->container[$alias];
    }
    
    /**
     * 取得实例数组
     * 
     * @return array
     */
    public function getInstances() {
        return $this->container;
    }
    
    /**
     * 创建一个新实例
     * 
     * @param string $alias
     * @throws \ClassNotFoundException
     * @return \ReflectionClass
     */
    public function newInstance($alias) {
        $info = $this->di->getDependencyContainer()->getContainer($alias);
        try {
            $instance = new \ReflectionClass($info['class']);
        } catch (\ReflectionException $e) {
            throw new \ClassNotFoundException('Class Not Found ' . $info['class'] . '().', E_RECOVERABLE_ERROR);
        }

        $construct = $instance->getConstructor();
        print_r($construct->getParameters());
        
        $instance->newInstanceArgs($info['params']);
        return $instance;
    }
}