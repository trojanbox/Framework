<?php
namespace Trojanbox\File;

use Trojanbox\File\FileInterface\OutputStreamInterface;
use Trojanbox\File\FileInterface\FileInterface;

class Reader implements OutputStreamInterface {
	
	private $_file;
	private $_fileHandle;
	
	/**
	 * 构造输出流
	 * @param FileInterface $file
	 */
	public function __construct(FileInterface $file) {
		$this->_file = $file;
		$this->_fileHandle = fopen($file->getFile(), 'r+');
	}
	
	/**
	 * 按行读取
	 * @param string $length
	 * @return boolean|string
	 */
	public function readLine($length = null) {
		if (feof($this->_fileHandle)) return false;
		if ($length == null) {
			return fgets($this->_fileHandle);
		} else {
			return fgets($this->_fileHandle, $length);
		}
	}
	
	/**
	 * 关闭输出流
	 */
	public function close() {
		fclose($this->_fileHandle);
	}
	
}