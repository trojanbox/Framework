<?php
namespace Trojanbox\Framework;

abstract class Instance {
	
	public static $self = null;
	
	static public function getClassName() {
		return null;
	}
	
	/**
	 * 单一实例构造器
	 * 继承Instance类必须实现 static getClassName() { return get_class() };
	 */
	final static public function getInstance() {
		if (static::$self === null) {
			$className = static::getClassName();
			if (empty($className)) throw new \Exception('未实现getClassName()方法');
			static::$self = new $className();
		} 
		return static::$self;
	}
}