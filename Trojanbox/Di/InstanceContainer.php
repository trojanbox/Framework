<?php
namespace Trojanbox\Di;

use Trojanbox\Di\DiInterface\ContainerInterface;
use Trojanbox\Di\Exception\CurrentlyInCreationException;
use Trojanbox\Di\Exception\DiException;

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
    public function getInstances()
    {
        return $this->container;
    }

    /**
     * 创建一个新实例
     *
     * @param string $alias            
     * @throws \ClassNotFoundException
     * @return \ReflectionClass
     */
    public function newInstance($alias, &$counter = array())
    {
        try {
            if (! is_string($alias))
                throw new \ReflectionException('Array to string conversion', E_NOTICE);
            
            $tmp = str_replace('.', '\\', $alias);
            $instance = new \ReflectionClass($tmp);
            return $instance->newInstance();
        } catch (\ReflectionException $e) {
            try {
                if (! is_string($alias))
                    throw new DiException('Array to string conversion', E_NOTICE);
                if (isset($counter[$alias]) && $counter[$alias] == true)
                    throw new CurrentlyInCreationException('Di can not handle the iteration loop', E_ERROR);
                
                $info = $this->di->getDependencyContainer()->getContainer($alias);
                $instance = new \ReflectionClass($info['class']);
                $construct = $instance->getConstructor();
                $paramsQueue = array();
                $counter[$alias] = true;
                foreach ($info['params'] as $parameter) {   
                    array_push($paramsQueue, $this->newInstance($parameter, $counter));
                }
            } catch (DiException $e) {
                return $alias;
            } catch (\ReflectionException $e) {
                throw new \ClassNotFoundException('Class Not Found ' . $info['class'] . '().', E_RECOVERABLE_ERROR);
            }
            return $instance->newInstanceArgs($paramsQueue);
        }
    }
}