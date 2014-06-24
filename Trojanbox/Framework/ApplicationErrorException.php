<?php
namespace Trojanbox\Framework;

/**
 * 应用程序错误处理
 * @author Administrator
 *
 */
class ApplicationErrorException extends \ErrorException {

	public function __toString() {
	
		$errorInfomation = '<html><body><p style="font-family: \'consolas\', \'宋体\'; font-size: 22px; font-weight: bolder;">Error Message: ' . $this->message;
		$errorInfomation .= '<br /><font style="font-size: 18px;">>> Error Code ' . $this->code .  '</font>';
		$errorInfomation .= '<br /><font style="font-size: 18px;">>> ' . $this->file . ' [' . $this->line . ']' . '</font></p>';
	
		foreach ($this->getTrace() as $key => $value) {
			$errorInfomation .= '<p style="font-family: \'consolas\', \'宋体\';"><font style="font-weight: bolder;">## ' . $key . '</font> ';
			$errorInfomation .= empty($value['class']) ? null : $value['class'];
			$errorInfomation .= empty($value['type']) ? null : $value['type'];
			$errorInfomation .= empty($value['function']) ? null : $value['function'];
	
			//$args = empty($value['args']) ? null : implode(', ', $value['args']);
			$errorInfomation .= '(' . ')';
			$errorInfomation .= '<br />&nbsp;&nbsp;&nbsp;';
			$errorInfomation .= empty($value['file']) ? 'No Found directory' : $value['file'];
			$line = empty($value['line']) ? '?' : $value['line'];
			$errorInfomation .= ' [' . $line . '] ' . '</p>';
		}
		$errorInfomation .= '</body></html>';
	
		return $errorInfomation;
	}

}