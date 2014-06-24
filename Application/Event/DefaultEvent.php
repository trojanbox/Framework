<?php
namespace Application\Event;

use Trojanbox\EventManager\EventManagerInterface\AbstractFactoryInterface;

class DefaultEvent implements AbstractFactoryInterface {

	public function __construct() {
		
	}
	
	public function handle() {
		echo "This is Default Event!<br>";
	}
	
}