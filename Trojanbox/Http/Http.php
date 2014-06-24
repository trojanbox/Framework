<?php
namespace Trojanbox\Http;

use Trojanbox\Http\Exception\HttpException;
class Http {
	
	
	/**
	 * 将URI数组进行编码
	 * @param array $uri
	 * @throws HttpException
	 * @return string
	 */
	static function httpUriEncode(array $uri, $numeric_prefix = null) {
		
		if (!is_array($uri)) {
			throw new HttpException('只接受 Array 类型。');
		}
		
		return http_build_query($uri, $numeric_prefix);
		
	}
	
}