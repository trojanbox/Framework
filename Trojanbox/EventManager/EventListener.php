<?php
namespace Trojanbox\EventManager;

use Trojanbox\EventManager\EventManagerInterface\EventListenerInterface;

class EventListener implements EventListenerInterface {
	
	public $_arrayConfig = null;
	public $_eventManager = null;
	
	public function __construct($config) {
		$this->_arrayConfig = $config;
	}
	
	/**
	 * 创建监听
	 * @param unknown $a
	 */
	public function listen($string) {
		return new ListenerManager($this, $string);
	}
	
	/**
	 * 设置事件管理器
	 * @param EventManager $eventManager
	 */
	public function setEventManager(EventManager $eventManager) {
		$this->_eventManager = $eventManager;
		return $this;
	}
}
