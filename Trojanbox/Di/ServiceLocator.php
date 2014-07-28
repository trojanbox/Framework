<?php
namespace Trojanbox\Di;

use Trojanbox\Di\Exception\ServiceLocatorException;
class ServiceLocator
{
	
    private $service = array();
    
    private $instance = array();
    
    protected function __construct()
    {
    }
    
    public function register($id, $config = null)
    {
        $this->service[$id] = $config;
    }
    
    public function hasService($id)
    {
    	return array_key_exists($id, $this->service);
    }
    
    public function getService($id)
    {
    	if (array_key_exists($id, $this->service)) {
    	    
    	} else {
    	    throw new ServiceLocatorException("Unknown service $id.", E_WARNING);
    	}
    }
    
    public function newInstance()
    {
    	
    }
}