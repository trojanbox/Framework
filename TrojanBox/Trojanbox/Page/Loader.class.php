<?php
namespace Trojanbox\Page;
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
			case 'BasicPage':
				$page = new \Trojanbox\Page\BasicPage\Center();
				return $page;
				break;
			default:
				throw new \Exception('未知类型！');
				break;
		}
	}
}