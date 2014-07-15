<?php
namespace Trojanbox\Event;

use Trojanbox\Event\EventInterface\BehaviorListenerInterface;

/**
 * 行为监视器
 */
class BehaviorListener extends ListenerAbstract implements BehaviorListenerInterface {

	private $_eventLists;
	private $_listenerName;
	
	public function __construct($listenerName) {
		$this->_listenerName = $listenerName;
	}
	
	public function monitor() {
		if ($this->_listenerState == false) return false;
		$this->executeEvents();
	}
}