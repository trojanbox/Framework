<?php
namespace Trojanbox\Cache;

class Loader {
	private function __construct() {}
	
	/**
	 * 创建缓存
	 * @param string $config 配置Array
	 * @throws \Trojanbox\Exception
	 * @return \Trojanbox\Db\Mysql\Center
	 */
	public static function Factory($config = null) {
		if (is_null($config['_TYPE'])) throw new \Exception('传入参数不能为空！');
		include_once FRAMEWORK . 'Cache' . DIRECTORY_SEPARATOR . 'Cache.interface.php';
		switch ($config['_TYPE']) {
			case 'file':
				$cahce = new \Trojanbox\Cache\File\Center();
				if (!empty($config)) $cahce->setConfig($config);
				return $cahce;
				break;
			default:
				throw new \Exception('未知类型！');
				break;
		}
	}
}