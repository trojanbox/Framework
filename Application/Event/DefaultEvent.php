<?php
namespace Application\Event;

use Trojanbox\Event\EventAbstract;

class DefaultEvent extends EventAbstract {
	
	public function handle() {
		echo $this->getName();
	}
	
}