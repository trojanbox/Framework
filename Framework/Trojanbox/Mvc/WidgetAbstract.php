<?php
namespace Trojanbox\Mvc;

abstract class WidgetAbstract
{
    protected $data = array();
    
    final public function __construct(array $data = array())
    {
        $this->data = $data;
    }
    
    final public function __get($key)
    {
    	if (array_key_exists($key, $this->data)) {
    	    return $this->data[$key];
    	}
    	return null;
    }
    
    /**
     * 定义微件的主体内容<br />
     * 通过 $this->xx 直接调用传进来的参数，如果参数不存在则返回空。
     */
	abstract public function main();
	
	final public function render()
	{
	    
	}
}