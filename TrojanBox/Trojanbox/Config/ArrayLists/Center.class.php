<?php
namespace Trojanbox\Config\ArrayLists;

class Center {
	
	protected $configFileContent = null;
	
	/**
	 * 设置配置文件
	 * @param string $name 配置文件名称（全称，包括扩展名）
	 * @return \Trojanbox\Config\ArrayLists\Center
	 */
	public function setConfigFile($name = null) {
		if (empty($name)) $name = 'config.php';
		if (!is_file(APP_APPLICATION_CONFIG . $name)) \Exception('配置文件不存在！');
		$this->configFileContent = include APP_APPLICATION_CONFIG . $name;
		return $this;
	}
	
	/**
	 * 获取配置文件详细
	 */
	public function getConfig() {
		if (empty($this->configFileContent)) throw new \Exception('无法获取配置文件，请执行' . __CLASS__ . '::setConfigFile 构建配置文件！');
		return $this->configFileContent;
	}
}