<?php
namespace Trojanbox\Db;

/**
 * XML 解析器 通用编程接口
 *
 */
interface DbInterface {
	
	/**
	 * Limit 语句分支
	 * @param number $limit 截取
	 * @param number $len 长度
	 */
	public function limit($limit = 0, $len = 10);
	
	/**
	 * Where 语句分支
	 * @param string $where 
	 */
	public function where($where = null);
	
	/**
	 * From 语句分支
	 * @param string $from
	 */
	public function from($from = null);
	
	/**
	 * Order By 语句分支
	 * @param string $order
	 */
	public function order($order = null);
	
	/**
	 * Group By 语句分支
	 * @param string $group
	 */
	public function group($group = null);
	
	/**
	 * Left Join 语句分支
	 * @param string $join
	 */
	public function join($join = null);
	
	/**
	 * Sql 删除
	 */
	public function delete();
	
	/**
	 * Sql 添加
	 */
	public function insert();
}

interface DbSelectInterface {
	/**
	 * 将结果格式化成数组
	 */
	function toArray();
	
	/**
	 * 将结果格式化成字符串
	 */
	function toString();
}
