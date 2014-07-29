<?php
namespace Trojanbox\Di;

use Trojanbox\Di\Exception\DiException;

class DiManager
{

    private static $self = null;

    private $dependencyContainer = null;

    private $instanceContainer = null;

    public function __construct()
    {
        $this->dependencyContainer = new DependencyContainer($this);
        $this->instanceContainer = new InstanceContainer($this);
    }

    public function __get($params)
    {
    	return $this->get($params);
    }
    
    /**
     * 取得依赖容器
     *
     * @return \Trojanbox\Di\DependencyContainer
     */
    public function getDependencyContainer()
    {
        return $this->dependencyContainer;
    }

    /**
     * 取得实例容器
     *
     * @return \Trojanbox\Di\InstanceContainer
     */
    public function getInstanceContainer()
    {
        return $this->instanceContainer;
    }

    /**
     * 设置对象
     *
     * @param array $config 详细参数
     * @throws DiException
     */
    public function set($alias, $config)
    {
        $this->dependencyContainer->setContainer($alias, $config);
    }

    /**
     * 获取对象
     * 
     * @param string $alias
     */
    public function get($alias)
    {
        return $this->dependencyContainer->getContainerInstance($alias);
    }
}