<?php
namespace Trojanbox\Di;

use Trojanbox\Di\Exception\ServiceLocatorException;

class ServiceLocator
{
    
    private static $instance = array();
    
    protected function __construct()
    {}
    
    /**
     * 注册服务
     * 
     * @param string $id
     * @param string $config
     */
    public static function register($id,$object = null)
    {
        self::$instance[$id] = $object;
    }
    
    /**
     * 检查服务是否存在
     * 
     * @param string $id
     * @return boolean
     */
    public function hasService($id)
    {
    	return array_key_exists($id, self::$instance);
    }
    
    /**
     * 取得服务
     * 
     * @param string $id
     * @throws ServiceLocatorException
     */
    public static function getService($id)
    {
    	if (array_key_exists($id, self::$instance)) {
    	    return self::$instance[$id];
    	} else {
    	    throw new ServiceLocatorException("Unknown service $id.", E_WARNING);
    	}
    }
    
    public static function __callstatic($name, $params)
    {
    	if (array_key_exists($name, self::$instance)) {
    	    return self::getService($name);
    	}
    	throw new ServiceLocatorException('Unknown service \'' . $name . '\'');
    }
}