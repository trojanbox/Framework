<?php
namespace Application\Controller\Admin;

use Trojanbox\Framework\Controller;
use Application\Engine\UserLoginEngine;

class IndexController extends Controller {
	
	public function init() {
		parent::init();
		if (!UserLoginEngine::getInstance()->isLogin()) {
			echo "<script>window.location.href = '/admin/user/login';</script>";
			exit();
		}
	}
	
	public function indexAction() {
		$this->display();
	}
	
	public function topAction() {
		$this->display();
	}
	
	public function leftAction() {
		$this->display();
	}
	
	public function rightAction() {
		$this->display();
	}
}
