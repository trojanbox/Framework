<?php
namespace Trojanbox\Verification\Request;

class Center {
	
	/**
	 * 判断请求来源是不是本域
	 */
	public function isParentDomain() {
		if (isset($_SERVER['HTTP_REFERER'])){
			if (preg_match('/^http:\/\/' . $_SERVER['HTTP_HOST'] . '/', $_SERVER['HTTP_REFERER'])) return true;
		}
		return false;
	}
	
	/**
	 * 判断是不是AJAX请求
	 */
	public function isAjax() {
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') return true;
		return false;
	}
}