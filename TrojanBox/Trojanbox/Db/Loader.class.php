<?php
namespace Trojanbox\Db;
class Loader {
	
	private function __construct() {}
	
	/**
	 * 创建数据库链接
	 * @param string $name 数据库类型
	 * @param string $config 配置Array
	 * @throws \Exception
	 * @return \Trojanbox\Db\Mysql\Center
	 */
	public static function Factory($config = null) {
		if (is_null($config['_TYPE'])) throw new \Exception('选择器type不能为空！');
		switch ($config['_TYPE']) {
			case 'Mysql':
				$mysql = new \Trojanbox\Db\Mysql\Center();
				if (!empty($config)) $mysql->setConfig($config);
				return $mysql;
				break;
			case 'Pdo':
				$pdo = new \Trojanbox\Db\Pdo\Center();
				if (!empty($config)) $pdo->setConfig($config);
				return $pdo;
				break;
			default:
				throw new \Exception('未知类型！');
				break;
		}
	}
}