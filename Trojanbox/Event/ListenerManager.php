<?php
namespace Trojanbox\Event;

use Trojanbox\Event\EventInterface\ListenerInterface;

class ListenerManager implements \Iterator {
	
	private $_listenerLists;
	private static $_self;
	private $_vaild = true;
	
	private public function __construct() {}
	
	/**
	 * 取得监听管理器的实例
	 * @return \Trojanbox\Event\ListenerManager
	 */
	public static function getInstance() {
		if (self::$_self instanceof self) {
			self::$_self = new self();
		}
		return self::$_self;
	}
	
	/**
	 * 注册到监听管理器
	 * @param ListenerInterface $listener
	 */
	public function registerListener(ListenerInterface $listener) {
		$this->_listenerLists[$listener->getName()] = $listener;
	}
	
	/**
	 * 移除指定监视器
	 * @param string $listenerName 监视器名称
	 */
	public function removeListener($listenerName) {
		unset($this->_listenerLists[$listenerName]);
	}
	
	/**
	 * 取得监视器列表
	 */
	public function getListeners() {
		return $this->_listenerLists;
	}
	
	/**
	 * 取得指定监视器
	 * @param string $listenerName 监视器名称
	 */
	public function getListener($listenerName) {
		return $this->_listenerLists[$listenerName];
	}
	
	/**
	 * 判断监视器是否存在
	 * @param string $listenerName 监视器名称
	 */
	public static function existListener($listenerName) {
		return array_key_exists($listenerName, $this->_listenerLists);
	}
	
	public function current() {
		return current($this->_listenerLists);
	}

	public function next() {
		$this->_vaild = (false !== next($this->_listenerLists));
	}

	public function key() {
		return key($this->_listenerLists);
	}

	public function valid() {
		return $this->_valid;
	}

	public function rewind() {
		$this->vaild = (false !== reset($this->_listenerLists));
	}

}