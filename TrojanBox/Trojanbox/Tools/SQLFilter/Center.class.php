<?php
namespace Trojanbox\Tools\SQLFilter;

/**
 * SQL 注入过滤器
 * @author 权
 */
class Center {

	/**
	 * 基本过滤器 - 为\Trojanbox\Db提供基本防注入支持，你可以重载此方法以适应各种需求
	 * @param $string
	 */
	public function basicFilter($string = null) {
		if (is_string($string))
			return addslashes($string);
		return $string;
	}
}