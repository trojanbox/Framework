<?php
namespace Trojanbox\Framework\FrameworkTrait;

/**
 * 单例模式
 * 使用 SingleInstanceTrait::getInstance() 获得单一实例对象
 * 构造器将无法使用
 */
trait SingleInstanceTrait {

	private static $_self = null;

	protected function __construct() {}

	final public static function getInstance() {
		if (!(static::$_self instanceof self)) {
			static::$_self = new self();
		}
		return static::$_self;
	}

}