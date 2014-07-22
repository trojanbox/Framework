<?php
namespace Trojanbox\Event;

abstract class EventAbstract {
	
	private $_eventName;
	
	public function __construct($eventName) {
		$this->_eventName = $eventName;
		EventManager::getInstance()->registerEventHandle($this);
	}
	
	/**
	 * 事件处理句柄
	 */
	public function handle() {}
	
	/**
	 * 取得事件名称
	 */
	public function getName() {
		return $this->_eventName;
	}
}