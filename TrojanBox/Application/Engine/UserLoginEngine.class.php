<?php
namespace Application\Engine;

use Application\Model\UserModel;
use Trojanbox\Framework\Instance;

class UserLoginEngine extends Instance {
	
	public static $self = null;
	private $user;
	
	public static function getClassName() {
		return get_class();
	}
	
	public function __construct() {
		$this->user = new UserModel();
	}
	
	/**
	 * 判断是否登陆
	 * @return boolean
	 */
	public function isLogin() {
		if (empty($_SESSION['USER_LOGIN_INFORMATIONAL'])) return false;
		if (!empty($_SESSION['USER_LOGIN_INFORMATIONAL']['loginState']) && $_SESSION['USER_LOGIN_INFORMATIONAL']['loginState'] == true) return true;
		return false;
	}
	
	/**
	 * 创建用户登陆信息
	 * @param string $data
	 * @throws \Exception
	 * @return boolean
	 */
	public function createLogin($data = null) {
		if (empty($data)) throw new \Exception(__METHOD__ . '无参数！');
		$userInfo = $this->user->getUserInfo($data['username'], $data['password']);
		if (false !== $userInfo) {
			setcookie(session_name(), session_id(), time(), null, '/');
			$_SESSION['USER_LOGIN_INFORMATIONAL'] = $userInfo;
			$_SESSION['USER_LOGIN_INFORMATIONAL']['loginState'] = true;
			return true;
		} else {
			$this->exitLogin();
			return false;
		}
	}
	
	/**
	 * 退出登陆
	 * @return boolean
	 */
	public function exitLogin() {
		setcookie(session_name(), session_id(), time()-3600, null, '/');
		$_SESSION['USER_LOGIN_INFORMATIONAL'] = null;
		unset($_SESSION['USER_LOGIN_INFORMATIONAL']);
		return true;
	}
	
	/**
	 * 获取用户信息
	 * @return unknown
	 */
	public function getUserInfo() {
		return $_SESSION['USER_LOGIN_INFORMATIONAL'];
	}
}