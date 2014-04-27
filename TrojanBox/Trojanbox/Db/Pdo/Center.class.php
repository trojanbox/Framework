<?php
namespace Trojanbox\Db\Pdo;
class Center {
	
	public $isConnect = false;
	private $pdo = null;
	private $_where = null;
	private $_order = null;
	private $_limit = null;
	private $_select = null;
	private $_group = null;
	private $_from = null;
	private $_join = null;
	private $Select;
	private $_sql = null;
	protected $sqlFilter;
	protected $config = null;
	protected $dbInfo = array('DSN', 'USER', 'PWD', 'CHAR', 'OPTION', 'SQLFilter');
	
	public function __construct() {
		$this->loadClassFile();
	}
	
	/**
	 * 获取最后一次执行的SQL语句
	 * @return string
	 */
	final public function getLastSql() {
		return $this->_sql;
	}
	
	/**
	 * 获取PDO对象
	 * @return \pdo
	 */
	final public function getPdo() {
		return $this->pdo;
	}
	
	/**
	 * 加载必要的操作对象
	 */
	private function loadClassFile() {
		include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Select.class.php';
	}
	
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
		$this->config = $dbInfo;
		$this->sqlFilter = $dbInfo['SQLFilter'];
		return $this;
	}
	
	/**
	 * 连接数据库
	 * @return $this
	 */
	final public function connect() {
		if (empty($this->config)) throw new \Exception('数据库配置为空！');
		$this->pdo = new \pdo($this->config['DSN'], $this->config['USER'], $this->config['PWD'], $this->config['OPTION']);
		$this->pdo->query('SET NAMES ' . $this->config['CHAR']);
		$this->isConnect = true;
		return $this;
	}

	public function select($select = null) {
		
		$this->_select = $select;
		
		$select = (empty($this->_select)) ? '*' : $this->_select ;
		$order = (empty($this->_order)) ? '' : $this->_order ;
		$group = (empty($this->_group)) ? '' : $this->_group ;
		$limit = (empty($this->_limit)) ? '' : $this->_limit ;
		$from = (empty($this->_from)) ? '' : $this->_from ;
		$join = (empty($this->_join)) ? '' : $this->_join ;
		$where = (empty($this->_where)) ? '' : $this->_where ;
		$this->_sql = 'SELECT ' . $select . $from . $join . $where . $order . $group . $limit;
		
		//清除残留
		$this->_from = $this->_group = $this->_join = $this->_limit = $this->_order = $this->_select = $this->_where = null;
		return new \Trojanbox\Db\Pdo\Select($this);
	}
	
	public function where($where = null) {
		
		$this->_where = $where;
		$where = '';
		if (is_array($this->_where)) {
			foreach ($this->_where as $key => $value) {
				$keyArray = explode('.', $key);
				$keyA = null;
				foreach ($keyArray as $AKkey => $AValue) $keyA .= '`' . $AValue . '`' . '.';
				$key = substr($keyA, 0, strlen($keyA)-1);
				$key = $this->sqlFilter->basicFilter($key);
				$value = $this->sqlFilter->basicFilter($value);
				if (is_array($value)) {
					$whereIn = implode('\',\'', $value);
					$where .= $key . ' IN (\'' . $whereIn . '\')' . ' AND ';
				} else {
					$where .= $key . ' = ' . '\'' . $value . '\''  . ' AND ';
				}
			}
			if (substr($where, -4, 4) == 'AND ')
				$where = ' WHERE ' . substr($where, 0, strlen($where)-4);
		} elseif (is_string($this->_where)) {
			$where .= ' WHERE ' . $this->_where;
		} else {
			$where = '';
		}
		
		$this->_where = $where;
		
		return $this;
	}
	
	public function join($join = null) {
		$this->_join .= ' LEFT JOIN ' . $join . ' ';
		return $this;
	}
	
	public function limit($limit = 0, $len = null) {
		if (!empty($len)) $len = ' , ' . $len;
		$this->_limit = ' LIMIT ' . $limit . $len;
		return $this;
	}
	
	public function order($order = null) {
		$this->_order = 'ORDER BY ' . $order;
		return $this;
	}
	
	public function group($group = null) {
		$this->_group = ' GROUP BY ' . $group;
		return $this;
	}
	
	public function delete() {
		
	}
	
	public function from($from = null) {
		$fromArray = explode(' as ', $from);
		$keyA = null;
		foreach ($fromArray as $AKkey => $AValue) $keyA .= '`' . $AValue . '`' . ' as ';
		$from = substr($keyA, 0, strlen($keyA)-4);
		$this->_from = ' FROM ' . $from . ' ';
		return $this;
	}
	
	public function insert() {
		
	}
}
