<?php
namespace Application\Model;

use Trojanbox\Framework\Model;

class CommentModel extends Model {
	
	protected $_userId, $_parentId, $_articleId;
	protected $_commentIndexed;
	
	public function init() {
		
	}
	
	/**
	 * 设置父ID
	 * @param unknown $id
	 * @return \Application\Model\CommentModel
	 */
	public function setParentId($id) {
		$this->_parentId = $id;
		return $this;
	}
	
	/**
	 * 设置文章ID
	 * @param unknown $id
	 * @return \Application\Model\CommentModel
	 */
	public function setArticleId($id) {
		$this->_articleId = $id;
		$this->CommentListsCache = \Trojanbox\Cache\Loader::Factory(array('_TYPE' => 'file', 'time' => 0, 'prefix' => 'comlist_' . $this->_articleId . '_'));
		return $this;
	}
	
	/**
	 * 创建评论
	 * @param unknown $data
	 * @return boolean
	 */
	public function addComment($data) {
		if (is_null($this->_parentId) || is_null($this->_articleId)) return false;
		$sql = 'INSERT INTO `' . $this->getTableName() . '` (`pid`, `aid`, `user_name`, `content`, `add_time`, `freeze`)
				VALUES (\'' . $this->_parentId . '\', \'' . $this->_articleId . '\', \'' . $data['username'] . '\', \'' . $data['content'] . '\', \'' . date('YmdHis') . '\', 1)';
		
		if ($this->globals->sql->connect()->getPdo()->query($sql)) {
			$this->CommentListsCache->delAll();
			return true;
		}
		
		return false;
	}
	
	/**
	 * 获取文章评论
	 * @param number $limit
	 * @param number $end
	 * @return multitype:|string
	 */
	public function getCommentLists() {
		if (empty($this->_articleId)) return array();
		$sql = 'SELECT id, pid, aid, user_name, content, add_time FROM `' . $this->getTableName() . '` WHERE `aid` = ' . $this->_articleId . ' ORDER BY add_time DESC';
		if (false === ($select = $this->CommentListsCache->getCache($sql))) {
			$select = $this->globals->sql->connect()->getPdo()->query($sql)->fetchAll();
			$this->__getCommentLists($select, 1, $select);
			
			$newSelect = array();
			foreach ($select as $key => $value) {
				$this->__getCommentCount($value, 2, $returnCount);
				$value['_newfloor'] = $returnCount;
				$newSelect[$key] = $value;
			}
			$select = $newSelect;
			$this->CommentListsCache->setCache($sql, $select);
		}
		return $select;
	}
	
	/**
	 * 格式化
	 * @param unknown $data
	 * @param number $floor
	 * @param unknown $return
	 * @param number $default
	 */
	private function __getCommentLists($data ,$floor = 0, &$return, $default = 0) {
		$sqlHandle = $select = $this->globals->sql->connect()->getPdo();
		foreach ($data as $key => $value) {
			if (empty($default)) $default = $value['id'];
			if ($value['pid'] != 0) {
				$sql = 'SELECT id, pid, aid, user_name, content, add_time FROM `' . $this->getTableName() . '` WHERE `id` = ' . $value['pid'] . ' ORDER BY add_time DESC';
				$select = $sqlHandle->query($sql)->fetchAll();
				$value['_floor'] = $floor;
				$return[$key] = $value;
				$this->__getCommentLists($select, $floor+1, $return[$key]['_children'], $default);
			} else {
				$value['_floor'] = $floor;
				$return[$key] = $value;
			}
		}
	}
	
	/**
	 * 格式化
	 * @param unknown $data
	 * @param number $floor
	 * @param unknown $return
	 */
	private function __getCommentCount($data, $floor = 1, &$return) {
		if (!empty($data['_children'])) {
			foreach ($data['_children'] as $key => $value) {
				if (!empty($value['_children'])) {
					$floor += 2;
					$this->__getCommentCount($value['_children'][0], $floor, $return);
				} else {
					$return = $floor;
				}
				break;
			}
		} else {
			$floor--;
			$return = $floor;
		}
	}
	
}