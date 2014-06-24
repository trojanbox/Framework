<?php
namespace Trojanbox\EventManager;

use Trojanbox\EventManager\EventManagerInterface\AbstractFactoryInterface;

class EventProxy implements AbstractFactoryInterface {

	private $_event = null;
	
	/**
	 * 事件驱动代理
	 * @param AbstractFactoryInterface $event
	 */
	public function __construct($name, AbstractFactoryInterface $event) {
		$this->_event = $event;
		EventManager::getInstance()->addEvent($name, $this->_event);
	}
	
	/**
	 * 执行句柄
	 * @see \Trojanbox\EventManager\EventManagerInterface\AbstractFactoryInterface::handle()
	 */
	public function handle() {
		$this->_event->handle();
	}
	
}