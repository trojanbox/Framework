<?php
namespace Trojanbox\Di;

use Trojanbox\Di\Exception\DiException;

class DiConfig
{

    private $di = null;
    
    private $config = array();
    
    protected function __construct(DiManager $di, array $config)
    {
    	$this->di = $di;
    	$this->config = $config;
    	$this->iterator();
    }
    
    /**
     * 创建一个DI配置容器，返回一个完整的对象
     * 
     * @param Di $di
     * @param array $config
     * @return \Trojanbox\Di\DiConfig
     */
    public static function of(DiManager $di, array $config)
    {
    	$newInstance = new static($di, $config);
    	return $newInstance;
    }
    
    public function __get($params)
    {
        if (array_key_exists($params, get_object_vars($this))) {
        	return $this->{$params};
        } else {
            throw new DiException($params . ' property does not exist.', E_WARNING);
        }
    }
    
    protected function iterator()
    {
        foreach ($this->config as $key => $value) {
            $this->di->set($key, $value);
        }
    }
}