<?php
namespace Com\Trojanbox\Util;

use Trojanbox\Db\DBInterface\DBConnectInterface;

class DBConnection implements DBConnectInterface {
	
	/**
	 * 自动连接
	 * @var bool 设置数据库的自动连接，默认为 false 不自动连接
	 */
	private $_autoConnect = false;
	
	/**
	 * PDO 对象
	 * @var unknown
	 */
	private $_pdo = null;
	
	public function __construct($dsn, $user, $name) {
		
	}
	
	/**
	 * 创建PDO对象实例
	 */
	public function createPdoInstace() {
		
	}
	
	/**
	 * 获得PDO对象实例
	 * @return \Com\Trojanbox\Util\?
	 */
	public function newInstace() {
		return $this->_pdo;
	}
	
	/**
	 * 设置数据库自动连接
	 * @param string $connect
	 */
	public function setAutoConnect($connect = false) {
		$this->_autoConnect = $connect;
	}
	
	public function setActive($active = true) {
		
	}
	
	public function setAttribute() {
		
	}
	
	public function getAttribute() {
		
	}
	
}