<?php
namespace Trojanbox\Xml;

class Loader {
	
	/**
	 * 创建数据库链接
	 * @param string $name 数据库类型
	 * @param string $config 配置Array
	 * @throws \Exception
	 * @return \Trojanbox\Db\Mysql\Center
	 */
	public static function Factory($config = null) {
		if (is_null($config['_TYPE'])) throw new \Exception('请选择一个XML解析器！');
		switch ($config['_TYPE']) {
			case 'DOMDocument':
				$DOMDocument = new \Trojanbox\Xml\DOMDocument\Center();
				return $DOMDocument;
				break;
			default:
				throw new \Exception('未知的XML解析器！');
				break;
		}
	}
}
