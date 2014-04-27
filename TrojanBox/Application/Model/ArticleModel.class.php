<?php
namespace Application\Model;
use Trojanbox\Framework\Model;

class ArticleModel extends Model {
	public function init() { 
		$this->articleListCache = \Trojanbox\Cache\Loader::Factory(array('_TYPE' => 'file', 'time' => 0, 'prefix' => 'artlist_'));
		$this->articleCache = \Trojanbox\Cache\Loader::Factory(array('_TYPE' => 'file', 'time' => 0, 'prefix' => 'article_'));
	}

	/**
	 * 获取文章总数
	 * @return unknown
	 */
	public function getArticleCount() {
		$sqlObject = $this->sql->from($this->getTableName())->select('count(id)');
		if (false === ($select = $this->articleListCache->getCache($sqlObject->toString()))) {
			$this->sql->connect();
			$select = $sqlObject->toArray();
			$this->articleListCache->setCache($sqlObject->toString(), $select);
		}
		if (empty($select[0][0])) return 0;
		return $select[0][0];
	}
	
	/**
	 * 获取文章列表
	 * @return unknown
	 */
	public function getArticleLists($limit = 0, $end = 10) {
		$sql = 'SELECT art.id, art.title, art.title_sim as description, art.publish_data as add_time, art.key, group.name, group.id as gid, user.nickname, user.id as uid 
				FROM `' . $this->getTableName() . '` as art
				LEFT JOIN `group` ON group.id = art.classify_id
				LEFT JOIN `user` ON user.id = art.author_id
				ORDER BY art.publish_data DESC
				LIMIT ' . $limit . ',' . $end;
		if (false === ($select = $this->articleListCache->getCache($sql))) {
			$select = $this->sql->connect()->getPdo()->query($sql)->fetchAll();
			$this->articleListCache->setCache($sql, $select);
		}
		return $select;
	}
	
	/**
	 * 获取文章详细
	 */
	public function getArticleInfo($aid = null) {
		if (empty($aid)) throw new \Exception(__METHOD__ . '不接受空参数！');
		$sql = $sql = 'SELECT art.id, art.title, art.title_sim as description, art.content, art.publish_data as add_time, art.key, group.name, group.id as gid,
						user.nickname, user.id as uid
						FROM `' . $this->getTableName() . '` as art
						LEFT JOIN `group` ON group.id = art.classify_id
						LEFT JOIN `user` ON user.id = art.author_id
						WHERE art.id = \'' . $aid . '\'
						LIMIT 1';
		if (false === ($select = $this->articleCache->getCache($aid))) {
			$select = $this->sql->connect()->getPdo()->query($sql)->fetch();
			$this->articleCache->setCache($aid, $select);
		}
		return $select;
	}
	
	/**
	 * 添加文章
	 * @param unknown $data
	 * @return boolean
	 */
	public function addArticle($data) {
		$sql = 'insert into `article` (`classify_id`, `author_id`, `title`, `title_sim`, `content`, `publish_data`, `key`)
				values (\'' . $data['classify_id'] . '\', \'' . $data['author_id'] . '\', \'' . $data['title'] . '\'
						, \'' . $data['title_sim'] . '\', \'' . $data['content'] . '\', \'' . date('YmdHis') . '\', \'' . $data['key'] . '\')';
		if ($this->globals->sql->connect()->getPdo()->query($sql)) {
			$this->articleListCache->delAll();
			return true;
		}
		return false;
	}
	
	/**
	 * 编辑文章
	 * @param unknown $data
	 * @return boolean
	 */
	public function editArticle($data) {
		$sql = "UPDATE `article` 
				SET `classify_id` = '" . $data['classify_id'] . "', `author_id` = '" . $data['author_id'] . "',
					`title` = '" . $data['title'] . "', 
					`title_sim` = '" . $data['title_sim'] . "', `content` = '" . $data['content'] . "',
					`key` = '" . $data['key'] . "' 
				WHERE `article`.`id` = " . $data['id'];
		if ($this->globals->sql->connect()->getPdo()->query($sql)) {
			$this->articleCache->delCache($data['id']);
			$this->articleListCache->delAll();
			return true;
		}
		return false;
	}
	
	/**
	 * 删除文章
	 * @param unknown $id
	 * @return boolean
	 */
	public function deleteArticle($id) {
		$sql = 'DELETE FROM `' . $this->getTableName() . '`
				WHERE id = \'' . $id . '\'';
		if ($this->globals->sql->connect()->getPdo()->query($sql)) {
			$this->articleCache->delCache($id);
			$this->articleListCache->delAll();
			return true;
		}
		return false;
	}
	
	/**
	 * 根据分组Id获取文章列表
	 * @param unknown $gid
	 * @param number $limit
	 * @param number $end
	 * @return Ambigous <boolean, mixed>
	 */
	public function getArticleByGroup($gid, $limit = 0, $end = 10) {
		$sql = 'SELECT id, title, title_sim, publish_data, `key`
				FROM `' . $this->getTableName() . '`
				WHERE classify_id = \'' . $gid . '\'
				ORDER BY publish_data DESC
				LIMIT ' . $limit . ',' . $end;
		if (false === ($select = $this->articleListCache->getCache($gid))) {
			$select = $this->globals->sql->connect()->getPdo()->query($sql)->fetchAll();
			$this->articleListCache->setCache($gid ,$select);
		}
		return $select;
	}
	
	/**
	 * 获取分组Id Count
	 * @param unknown $gid
	 * @return Ambigous <>
	 */
	public function getArticleByGroupCount($gid) {
		$sql = 'SELECT count(id)
				FROM `' . $this->getTableName() . '`
				WHERE classify_id = \'' . $gid . '\'';
		if (false === ($select = $this->articleListCache->getCache($sql))) {
			$select = $this->globals->sql->connect()->getPdo()->query($sql)->fetch();
			$this->articleListCache->setCache($sql, $select);
		}
		
		return $select[0];
	}
}