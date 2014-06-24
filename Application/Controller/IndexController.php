<?php
namespace Application\Controller;

use Trojanbox\Framework\Controller;

class IndexController extends Controller {
	
	public function indexAction() {
		
		$this->display();
		
	}
	
	public function aAction() {
		echo 'ff';
	}
	
}