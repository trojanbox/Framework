<?php
namespace Trojanbox\File;

use Trojanbox\File\FileInterface\FileInterface;
use Trojanbox\File\Exception\FileNotFoundException;

class File implements FileInterface {
	
	private $_fileDirectory;
	
	/**
	 * 构造文件对象
	 * @param unknown $fileName
	 * @throws FileNotFoundException
	 */
	public function __construct($fileName) {
		if (!is_file($fileName)) {
			throw new FileNotFoundException('文件不存在' . $this->_fileDirectory . '。<br />' . $fileName);
		}
		$this->_fileDirectory = $fileName;
	}
	
	/**
	 * 获取文件详细
	 */
	public function getFile() {
		return $this->_fileDirectory;
	}
	
	/**
	 * 获取文件名称
	 * @return string
	 */
	public function getName() {
		return basename($this->_fileDirectory);
	}
	
	/**
	 * 获取文件目录
	 * @return string
	 */
	public function getDirectory() {
		return dirname($this->_fileDirectory);
	}
	
}