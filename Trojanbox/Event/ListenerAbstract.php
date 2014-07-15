<?php
namespace Trojanbox\Event;

use Trojanbox\Event\EventInterface\ListenerInterface;

abstract class ListenerAbstract implements ListenerInterface {
	
	private $_listenerName;
	private $_listenerState = true;
	
	public function getName() {
		return $this->_listenerName;
	}
	
	public function disableListener() {
		$this->_listenerState = false;
		return $this;
	}
	
	public function enableListener() {
		$this->_listenerState = true;
		return $this;
	}
	
	public function removeEventHandle($eventName) {
		unset($this->_eventLists[$eventName]);
	}
	
	public function existEvent($eventName) {
		return array_key_exists($eventName, $this->_eventLists);
	}
	
	public function getEventHandles() {
		return $this->_eventLists;
	}
	
	public function executeEvents() {
		if (empty($this->_eventLists)) return ;
		foreach ($this->_eventLists as $value) {
			$value->handle();
		}
	}
	
	public function addEventHandle($eventName, \Trojanbox\Event\EventInterface\EventInterface $event) {
		$this->_eventLists[$eventName] = $event;
	}
}