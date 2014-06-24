<?php
namespace Trojanbox\Config;

use Trojanbox\Config\Exception\ArrayConfigException;
use Trojanbox\Config\ConfigInterface\ArrayConfigInterface;
use Trojanbox\File\FileInterface\FileInterface;

class ArrayConfig implements ArrayConfigInterface {
	
	private $_config;
	
	/**
	 * 构造配置文件
	 * @param File $file
	 */
	public function __construct(FileInterface $file) {
		$this->_config = include $file->getFile();
	}
	
	/**
	 * 获取指定配置信息
	 * @param unknown $name
	 * @throws ArrayConfigException
	 */
	public function getConfig($name) {
		if (!array_key_exists($name, $this->_config)) {
			throw new ArrayConfigException('指定的配置信息不存在！');
		}
		return $this->_config[$name];
	}
	
	/**
	 * 取得全部配置信息
	 */
	public function getConfigAll() {
		return $this->_config;
	}
}