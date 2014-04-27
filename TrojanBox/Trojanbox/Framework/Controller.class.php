<?php
namespace Trojanbox\Framework;

class Controller {
	
	protected $view;
	
	final public function __construct() {
		$this->globals = \Trojanbox\Globals\Loader::getInstance();
		$globalsControllerLists = $this->globals->get('C');
		foreach ($globalsControllerLists as $key => $value) $this->{$key} = $value;
		$this->_execView();
		$this->init();
	}
	
	protected function init() {}
	
	private function _execView() {
		$this->view = new \Trojanbox\Framework\View();
		return $this;
	}
	
	protected function display($fileName = null) {
		$this->view->display($fileName);
	}
}