<?php
namespace Trojanbox\Event;

use Trojanbox\Event\EventInterface\BehaviorListenerInterface;

class BehaviorListener implements BehaviorListenerInterface {

	private $_eventLists;
	
	public function __construct($listenerName) {
		
	}

	public function monitor() {
		
	}

	public function disableListener() {
		
	}

	public function enableListener() {
		
	}
	
	public function addEventHandle($eventName,\Trojanbox\Event\EventInterface\EventInterface $event) {
		
	}

	public function removeEventHandle($eventName) {
		
	}

	public function getEventHandles() {
		
	}

	public function executeEvent($eventName) {
		
	}
}