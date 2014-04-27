<?php
namespace Trojanbox\Db\Pdo;

class Select {
	
	private $db;
	
	public function __construct(\Trojanbox\Db\Pdo\Center $object) {
		$this->db = $object;
	}
	
	public function toArray() {
		$query = $this->db->getPdo()->query($this->db->getLastSql());
		if (is_object($query))
			$result = $query->fetchAll();
		else 
			return $query;
		return $result;
	}
	
	public function toString() {
		$this->db->getLastSql();
		return $this->db->getLastSql();
	}
}