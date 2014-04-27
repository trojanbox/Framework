<?php
namespace Trojanbox\Tools;

class Loader {
public static function Factory($config = null) {
		if (is_null($config['_TYPE'])) throw new \Exception(__METHOD__ . '不接受空参数！');
		switch ($config['_TYPE']) {
			case 'SQLFilter':
				$mysql = new \Trojanbox\Tools\SQLFilter\Center();
				return $mysql;
				break;
			default:
				throw new \Exception(__METHOD__ . '无法加载未知类型对象！');
				break;
		}
	}
}