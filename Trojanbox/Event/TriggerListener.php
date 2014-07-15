<?php
namespace Trojanbox\Event;

use Trojanbox\Event\EventInterface\TriggerListenerInterface;

class TriggerListener implements TriggerListenerInterface {

	private $_eventLists;
	
	public function __construct($listenerName, $triggerString) {
		
	}

	public function monitor($triggerString) {
		
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