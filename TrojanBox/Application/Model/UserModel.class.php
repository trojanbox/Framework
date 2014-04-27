<?php
namespace Application\Model;
use Trojanbox\Framework\Model;

class UserModel extends Model {
	
	public function init() {
		$this->sqlFilter = \Trojanbox\Tools\Loader::Factory(array('_TYPE' => 'SQLFilter'));
	}
	
	/**
	 * 获取用户信息
	 * @param string $username
	 * @param string $pwd
	 * @return boolean
	 */
	public function getUserInfo($username = null, $pwd = null) {
		if (empty($username) || empty($pwd)) return false;
		$sql = 'select * from `' . $this->sqlFilter->basicFilter($this->getTableName()) . '` ' .
				'WHERE `email` = \'' . $this->sqlFilter->basicFilter($username) . '\' ' . 
				'AND `password` = \'' . md5($this->sqlFilter->basicFilter($pwd)) . '\'';
		return $this->globals->sql->connect()->getPdo()->query($sql)->fetch();
	}
	
}