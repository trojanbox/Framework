<?php
namespace Trojanbox\Framework;

class Model {
	
	public $_TableName;
	protected $globals;
	
	final public function __construct() {
		$this->globals = \Trojanbox\Globals\Loader::getInstance();
		$globalsControllerLists = $this->globals->get('M');
		foreach ($globalsControllerLists as $key => $value) $this->{$key} = $value;
		$this->_execTableName();
		
		$this->init();
	}
	
	public  function init() {}
	
	/**
	 * 获取继承的类名
	 */
	private function _execTableName() {
		
		$classNameString = get_class($this);
		if (!preg_match('/Model/', $classNameString)) throw new \Exception('模型：解析类型过程中出现问题！');
		
		$className = explode('\\', $classNameString);
		$tableName = $className[count($className)-1];
		if (empty($tableName)) throw new \Exception('模型：获取表名失败！<br>可能原因：解析命名空间过程中出错！');
		preg_match_all('/([A-Z]){1}/', $tableName, $tableNameArray);
		$tableNameLength = strlen($tableName);
		$tableNameArrayCount = count($tableNameArray[1]);
		for ($i = 0; $i < $tableNameArrayCount; $i++) {
			if ($i <= 0)
				$tableNameSplit[] = substr($tableName, ($tableNameLength-strlen(strstr($tableName, $tableNameArray[1][$i]))), ($tableNameLength-strlen(strstr($tableName, $tableNameArray[1][$i+1]))));
			elseif ($i >= ($tableNameArrayCount-1)) 
				break;
			else 
				$tableNameSplit[] = substr($tableName, ($tableNameLength-strlen(strstr($tableName, $tableNameArray[1][$i]))), ($tableNameLength-strlen(strstr($tableName, $tableNameArray[1][$i+1]))-($tableNameLength-strlen(strstr($tableName, $tableNameArray[1][$i])))));
		}
		$this->_TableName = strtolower(implode('_', $tableNameSplit));
		if (empty($this->_TableName)) throw new \Exception('模型：在创建表名过程中出现严重问题！');
		return $this;
	}
	
	/**
	 * 获取表名
	 * @return string
	 */
	final public function getTableName() {
		return $this->_TableName;
	}
}