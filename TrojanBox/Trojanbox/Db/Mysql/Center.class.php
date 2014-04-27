<?php
namespace Trojanbox\Db\Mysql;
class Center {
	
	public $mysqli = null;
	protected $mysqlConfig = null;
	protected $dbInfo = array('HOST', 'DBNAME', 'USER', 'PWD', 'CHAR', 'PORT', 'SOCKET');
	
	/**
	 * 设置数据库连接
	 * @param unknown $config
	 * @return \Trojanbox\Db\Mysql\Center
	 */
	final public function setConfig($config = null) {
		if (empty($config)) throw new \Exception('不能传入空的数据库配置！');
		
		foreach ($this->dbInfo as $key => $value) if (array_key_exists($value, $config)) {
			$dbInfo[$value] = $config[$value]; 
		} else {
			$dbInfo[$value] = null;
		}
		$this->mysqlConfig = $dbInfo;
		return $this;
	}
	
	/**
	 * 连接数据库
	 * @return $this
	 */
	final public function connect() {
		if (empty($this->mysqlConfig)) throw new \Exception('数据库配置为空！');
		$this->mysqli = new \mysqli($this->mysqlConfig['HOST'], $this->mysqlConfig['USER'], $this->mysqlConfig['PWD'], $this->mysqlConfig['DBNAME'], $this->mysqlConfig['PORT'], $this->mysqlConfig['SOCKET']);
		if ($this->mysqli->connect_errno) {
			printf("Connect failed: %s\n", $mysqli->connect_error);
			exit();
		}
		
		$this->mysqli->query('set names ' . $this->mysqlConfig['CHAR']);
		return $this;
	}
}
