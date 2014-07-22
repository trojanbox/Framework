<?php
namespace Trojanbox\Event;

use Trojanbox\Event\Exception\EventException;
class EventManager implements \Iterator, \ArrayAccess {
	
	private $_eventLists;
	private static $_self;
	
	private function __construct() {}
	
	/**
	 * 事件管理器实例
	 */
	public static function getInstance() {
		if (!self::$_self instanceof self) {
			self::$_self = new self();
		}
		return self::$_self;
	}

	/**
	 * 注册事件句柄
	 * @param EventAbstract $event
	 */
	public function registerEventHandle(EventAbstract $event) {
		$this->_eventLists[$event->getName()] = $event;
	}
	
	/**
	 * 移除事件
	 * @param string $eventName
	 */
	public function removeEventHandle($eventName) {
		if (array_key_exists($eventName, $this->_eventLists)) {
			unset($this->_eventLists[$eventName]);
		}
	}
	
	/**
	 * 取得指定事件
	 * @param unknown $eventName
	 * @throws EventException
	 */
	public function getEventHandle($eventName) {
		if (array_key_exists($eventName, $this->_eventLists)) {
			return $this->_eventLists[$eventName];
		} else {
			throw new EventException('Not Found Event ' . $eventName . '.', E_WARNING);
		}
	}
	
	public function __get($name) {
		if (array_key_exists($name, $this->_eventLists)) {
			return $this->_eventLists[$name];
		} else {
			throw new EventException('Not Found Listener [' . $name . ']', E_WARNING);
		}
	}
	
	public function __set($key, EventAbstract $value) {
		if ($key != $value->getName()) {
			throw new EventException('Key should be equal to the listener name.', E_WARNING);
		}
		$this->_eventLists[$key] = $value;
	}
	
	public function current() {
		return current($this->_eventLists);
	}
	
	public function next() {
		$this->_vaild = (false !== next($this->_eventLists));
	}
	
	public function key() {
		return key($this->_eventLists);
	}
	
	public function valid() {
		return $this->_valid;
	}
	
	public function rewind() {
		$this->vaild = (false !== reset($this->_eventLists));
	}
	
	public function offsetExists($offset) {
		return array_key_exists($offset, $this->_eventLists);
	}
	
	public function offsetGet($offset) {
		if (array_key_exists($offset, $this->_eventLists)) {
			return $this->_eventLists[$offset];
		}
	}
	
	public function offsetSet($offset, $value) {
		if (!$value instanceof EventAbstract) {
			throw new EventException('Must extends abstract Trojanbox\Event\EventAbstact, string given', E_RECOVERABLE_ERROR);
		}
		if ($offset != $value->getName()) {
			throw new EventException('Key should be equal to the listener name.', E_WARNING);
		}
		$this->_eventLists[$offset] = $value;
	}
	
	public function offsetUnset($offset) {
		if (array_key_exists($offset, $this->_eventLists)) {
			unset($this->_eventLists[$offset]);
		}
	}
}