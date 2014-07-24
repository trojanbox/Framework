<?php
namespace Trojanbox\Di;

use Trojanbox\Di\Exception\DiException;
use Trojanbox\Di\DiInterface\ContainerInterface;

class DependencyContainer implements ContainerInterface
{

    private $container = array();

    private $di = null;
    
    public function __construct(Di $di)
    {
        $this->di = $di;
    }

    /**
     * 注册依赖
     * 
     * @param array $di            
     */
    public function setContainer(array $di)
    {
        $this->container = $di;
    }

    /**
     * 取得详细信息
     * 
     * @param string $alias
     * @throws DiException
     * @return array
     */
    public function getContainer($alias)
    {
        if (is_string($alias) && $this->hasAlias($alias)) {} else {
            throw new DiException('Not Found Alias ' . $alias . '.', E_NOTICE);
        }
        
        return $this->container[$alias];
    }

    /**
     * 取得依赖实例
     * 
     * @param string $alias
     * @throws DiException
     * @return Object
     */
    public function getContainerInstance($alias)
    {
        if (is_string($alias) && $this->hasAlias($alias)) {} else {
            throw new DiException('Not Found Alias ' . $alias . '.', E_NOTICE);
        }
        if ($this->di->getInstanceContainer()->hasInstance($alias)) {
            $instance = $this->di->getInstanceContainer()->getInstance($alias);
        } else {
            $instance = $this->di->getInstanceContainer()->newInstance($alias);
        }
        return $instance;
    }
    
    /**
     * 检查别名是否存在
     * 
     * @param string $alias
     * @return boolean
     */
    public function hasAlias($alias)
    {
        return array_key_exists($alias, $this->container);
    }
    
    /**
     * 取得別名数组
     * 
     * @return array
     */
    public function getContainers()
    {
        return $this->container;
    }
}