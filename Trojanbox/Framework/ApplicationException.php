<?php
namespace Trojanbox\Framework;

/**
 * Trojanbox 核心异常处理，所有自定义处理对象都需要继承此对象
 * @author trojanbox.com
 *
 */
class ApplicationException extends \Exception {
	
	public function __toString() {

		$errorInfomation = '<html><body><p style="font-family: \'consolas\', \'宋体\'; font-size: 22px; font-weight: bolder;">Exception Message: ' . $this->message;
		$errorInfomation .= '<br /><font style="font-size: 18px;">>> Exception Code ' . $this->code .  '</font>';
		$errorInfomation .= '<br /><font style="font-size: 18px;">>> ' . $this->file . ' [' . $this->line . ']' . '</font></p>';
		
		foreach ($this->getTrace() as $key => $value) {
			$errorInfomation .= '<p style="font-family: \'consolas\', \'宋体\';"><font style="font-weight: bolder;">>> ' . $key . '</font> ';
			$errorInfomation .= empty($value['class']) ? null : $value['class'];
			$errorInfomation .= empty($value['type']) ? null : $value['type'];
			$errorInfomation .= empty($value['function']) ? null : $value['function'];

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