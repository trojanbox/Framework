<?php
namespace Trojanbox\Tools;

use Trojanbox\Terminal\Terminal;
include 'Terminal.class.php';

/**
 * 事倍功半类
*/
class Tools {
	
	static private $Terminal = null;
	
	/**
	 * 跳转
	 * @param string $type <br>refresh 刷新 <b>不接受追加参数 允许为空 null</b> <br> redirect 跳转 <b>接受追加参数 不允许为空</b> <br> goback 后退
	 * @param string $append URL地址
	 * @param number $time
	 * @return string
	 */
	static public function redirect($string = null) {
		
		if (empty($string)) return false;
		
		if (self::$Terminal == null) {
			self::$Terminal = new Terminal();
		}
		self::$Terminal->cmd($string);

		switch (self::$Terminal->key('-m')) {
			case 'goback':
				break;
			case 'goto':
				if (is_null(self::$Terminal->key('-h'))) return false;
				if (is_null(self::$Terminal->key('-t'))) return false;
				$redirect = '
					<script>
						setTimeout(function () {
							window.location.href="' . self::$Terminal->key('-h') . '";
						},' . self::$Terminal->key('-t') . ');
					</script>
				';
				break;
			case 'refrash':
				break;
		}
		
		return $redirect;
	}
}