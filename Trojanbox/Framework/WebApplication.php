<?php
namespace Trojanbox\Framework;

require_once 'Framework.php';

/**
 * <b>创建一个Web应用程序，继承自 Framework。</b><br />
 * &nbsp;&nbsp;对 Framework 的一个集成，推荐使用 WebApplication 创建一个应用程序。<br />
 * &nbsp;&nbsp;如果尝试最大化自定义请使用 Framework 。<br />
 * &nbsp;&nbsp;self 会处理所有未被捕捉的程序异常与程序错误，所有的异常处理与错误处理都继承自 Exception 异常处理器。
 * 
 */
class WebApplication extends Framework {

	private $WORKSPACE = null;
	
	/**
	 * 设置应用程序扩展
	 * @param string $function
	 */
	public function setExtend($function = null) {
		$function($this);
	}
	
	public function __construct() {
		try {
			parent::__construct();
		} catch (\Exception $e) {
			echo $e;
		}
	}
	
	/**
	 * 执行
	 */
	public function run() {
		try {
			$this->letsGo();	// 执行
		} catch (\Exception $e) {	// 处理所有未被捕捉的异常
			echo $e;
		}
	}
}