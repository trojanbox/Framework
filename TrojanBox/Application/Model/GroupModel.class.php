<?php
namespace Application\Model;
use Trojanbox\Framework\Model;

class GroupModel extends Model {
	
	protected $_groupCache = null;
	protected $_sqlFilter = null;
	
	public function init() {
		$this->_sqlFilter = \Trojanbox\Tools\Loader::Factory(array('_TYPE' => 'SQLFilter'));
		$this->groupListCache = \Trojanbox\Cache\Loader::factory(array('_TYPE' => 'file', 'time' => 0, 'prefix' => 'glist_'));
		$this->groupInfoCache = \Trojanbox\Cache\Loader::factory(array('_TYPE' => 'file', 'time' => 0, 'prefix' => 'ginfo_'));
	}
	
	/**
	 * 获取分组列表对象
	 * @return \Application\Model\GroupModel
	 */
	public function getGroupLists() {
		$sql = 'select id, pid, name, description from `' . $this->getTableName() . '`';
		if (false === ($groupLists = $this->groupListCache->getCache($sql))) {
			$sqlFetch = $this->sql->connect()->getPdo()->query($sql);
			$groupLists = $sqlFetch->fetchAll();
			$this->groupListCache->setCache($sql, $groupLists);
		}
		$this->_groupCache = $groupLists;
		return $this;
	}
	
	/**
	 * 返回分组列表
	 */
	public function toArray() {
		return $this->_groupCache;
	}
	
	/**
	 * 获取树形结构
	 * @param number $pid
	 * @param number $floor
	 * @return unknown
	 */
	public function toTree($pid = 0, $floor = 1) {
		$this->__sysToTree($pid, $floor, $return);
		return $return;
	}
	
	/**
	 * 获取树形结构 内置方法
	 * @param number $pid
	 * @param number $floor
	 * @param unknown $return
	 */
	private function __sysToTree($pid = 0, $floor = 1, &$return = array()) {
		foreach ($this->_groupCache as $key => $value) {
			if ($value['pid'] == $pid) {
				$value['_floor_'] = $floor;
				$return[] = $value;
				$this->__sysToTree($value['id'], $floor+1,$return);
			}
		}
	}
	
	/**
	 * 添加新分组
	 * @param unknown $post
	 */
	public function createNewGroup($post) {
		$sql = 'insert into `group` (`pid`, `name`, `description`, `key`) 
				values (\'' . $this->_sqlFilter->basicFilter($post['pid']) . '\', \'' . $this->_sqlFilter->basicFilter($post['name']) . '\', \'' . $this->_sqlFilter->basicFilter($post['description']) . '\', \'' . $this->_sqlFilter->basicFilter($post['key']) . '\')';
		$this->globals->sql->connect();
		if ($this->globals->sql->getPdo()->query($sql)) {
			$this->groupListCache->delAll();
			return true;
		}
		return false;
	}

	/**
	 * 获取分组详细
	 * @param unknown $id
	 * @return boolean
	 */
	public function getGroup($id) {
		$sql = 'SELECT * FROM `' . $this->getTableName() . '` WHERE id = \'' . $id . '\'';
		if (false === ($select = $this->groupInfoCache->getCache($id))) {
			$select = $this->globals->sql->connect()->getPdo()->query($sql)->fetch();
			$this->groupInfoCache->setCache($id, $select);
		}
		return $select;
	}
	
	/**
	 * 分组编辑
	 * @param unknown $data
	 * @return boolean
	 */
	public function editGroup($data) {
		$sql = 'UPDATE `' . $this->getTableName() . '`
				SET `pid` = \'' . $data['pid'] . '\', `name` = \'' . $data['name'] . '\', `key` = \'' . $data['key'] . '\', `description` = \'' . $data['description'] . '\'
				WHERE `id` = \'' . $data['id'] . '\'';
		if ($this->globals->sql->connect()->getPdo()->query($sql)) {
			$this->groupInfoCache->delCache($data['id']);
			$this->groupListCache->delAll();
			return true;
		} 
		return false;
	}
	
	/**
	 * 获取子集栏目列表
	 * @param unknown $pid
	 * @param unknown $limit
	 * @param unknown $end
	 * @return Ambigous <boolean, mixed>
	 */
	public function getSubsetLists($pid, $limit, $end) {
		$sql = 'SELECT * FROM `' . $this->getTableName() . '` WHERE pid = \'' . $pid . '\' LIMIT ' . $limit . ',' . $end;
		if (false === ($select = $this->groupListCache->getCache($pid))) {
			$select = $this->globals->sql->connect()->getPdo()->query($sql)->fetch();
			$this->groupListCache->setCache($pid, $select);
		}
		return $select;
	}
	
	/**
	 * 删除分组
	 * @param unknown $id
	 * @return boolean
	 */
	public function deleteGroup($id) {
		$sql = 'DELETE FROM `' . $this->getTableName() . '` WHERE id = \'' . $id . '\'';
		if ($this->getSubsetLists($id, 0, 1)) return false;
		if ($this->globals->sql->connect()->getPdo()->query($sql)) {
			$this->groupInfoCache->delCache($id);
			$this->groupListCache->delAll();
			return true;
		}
	}
}