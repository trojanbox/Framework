<?php
namespace Trojanbox\Di;

use Trojanbox\Di\DiInterface\ContainerInterface;
use Trojanbox\Di\Exception\CurrentlyInCreationException;
use Trojanbox\Di\Exception\DiException;

class InstanceContainer implements ContainerInterface
{

    private $container = array();

    private $di = null;

    public function __construct(DiManager $di)
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
     * 产生一个注入实例
     * @param string $alias
     * @param int $counter
     * @throws CurrentlyInCreationException
     * @throws \NoSuchMethodException
     * @throws DiException
     * @throws \ClassNotFoundException
     * @return object
     */
    public function newInstance($alias, &$counter = array())
    {
        if (! is_string($alias))
            return $alias;
        
        $tmp = str_replace('.', '\\', $alias);
        if (class_exists($tmp)) {
            $instance = new \ReflectionClass($tmp);
            return $instance->newInstance();
        }
        
        if (!empty($counter[$alias]) && $counter[$alias] == true) {
            throw new CurrentlyInCreationException('Currently in creation');
        }
        
        try {
            // newInstance
            $dependencyInfo = $this->di->getDependencyContainer()->getContainer($alias);
            $dependencyInfo['class'] = str_replace('.', '\\', $dependencyInfo['class']);
            $instance = new \ReflectionClass($dependencyInfo['class']);
            $paramsQueue = array();
            $counter[$alias] = true;
            
            if (array_key_exists('factory', $dependencyInfo)) {
                // Factory
                try {
                    $factoryMethod = $instance->getMethod($dependencyInfo['factory']);
                } catch (\ReflectionException $e) {
                    throw new \NoSuchMethodException('No Such Method ' . $dependencyInfo['factory'], E_ERROR);
                }
                foreach ($dependencyInfo['params'] as $parameter) {
                    array_push($paramsQueue, $this->newInstance($parameter, $counter));
                }
                $newInstance = $factoryMethod->invokeArgs(null, $paramsQueue);
            } else {
                // Constructor
                $construct = $instance->getConstructor();
                foreach ($dependencyInfo['params'] as $parameter) {
                    array_push($paramsQueue, $this->newInstance($parameter, $counter));
                }
                $newInstance = $instance->newInstanceArgs($paramsQueue);
            }
            
            // Actions
            if (array_key_exists('actions', $dependencyInfo)) {
                if (! is_array($dependencyInfo['actions'])) {
                    throw new DiException('not array');
                }
                
                foreach ($dependencyInfo['actions'] as $key => $value) {
                    $paramsQueue = array();
                    try {
                        $instanceMethod = $instance->getMethod($key);
                    } catch (\ReflectionException $e) {
                        throw new \NoSuchMethodException('No Such Method ' . $key, E_ERROR);
                    }
                    foreach ($value as $parameter) {
                        array_push($paramsQueue, $this->newInstance($parameter, $counter));
                    }
                    $instanceMethod->invokeArgs($newInstance, $paramsQueue);
                }
            }
            
            return $newInstance;
        } catch (DiException $e) {
            if ($e->getMessage() == 'not array') {
                throw new DiException('Injection method profile exception: alias ' . $alias . ' - actions');
            }
            return $alias;
        } catch (\ReflectionException $e) {
            throw new \ClassNotFoundException('Class Not Found ' . $dependencyInfo['class'] . '().', E_RECOVERABLE_ERROR);
        }
    }
}