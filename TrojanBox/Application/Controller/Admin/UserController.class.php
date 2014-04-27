<?php
namespace Application\Controller\Admin;

use Trojanbox\Framework\Controller;
use Application\Engine\UserLoginEngine;

class UserController extends Controller {
	
	/**
	 * 登陆控制器
	 */
	public function loginAction() {
		if (!UserLoginEngine::getInstance()->isLogin()) {
			$this->display();
		} else {
			echo "<script>window.location.href = '/admin/';</script>";
		}
	}
	
	/**
	 * 退出登陆
	 */
	public function exitAction() {
		UserLoginEngine::getInstance()->exitLogin();
		echo "<script>window.location.href = '/';</script>";
	}
	
	/**
	 * 验证登录
	 */
	public function verifyAction() {
		
		if (empty($_POST['data'])) {
			echo 'not args';
			exit();
		}
		
		$dataArray = explode(';', $_POST['data']);
		if (empty($dataArray[0]) || empty($dataArray[1])) {
			echo 'args error';
			exit();
		}
		$this->userCenter = UserLoginEngine::getInstance();

		if (!$this->userCenter->isLogin()) {
			$loginStatic = $this->userCenter->createLogin(array('username' =>  $dataArray[0], 'password' => $dataArray[1]));
			if ($loginStatic) {
				echo 'login ok';
			} else {
				echo 'login error';
			}
			exit();
		}
		echo 'login finish?';
	}
}