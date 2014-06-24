<?php
namespace Trojanbox\Cache\Backend;

use Trojanbox\Cache\CacheInterface\CacheBackendInterface;
use Trojanbox\Cache\Exception\CacheBackendException;
use Trojanbox\File\Exception\DirectoryNotFoundException;
use Trojanbox\Cache\Exception\CacheFrontedException;

/**
 * 文件缓存后端
 * @author Administrator
 *
 */
class FileCacheBackend implements CacheBackendInterface {
	
	private $_defaultConfig = array('time' => '0', 'tag' => null, 'directory' => null);
	private $_config = null;
	
	/**
	 * 构造缓存后端
	 * @param unknown $config array(
	 * time, tag, directory
	 * )
	 */
	public function __construct($config) {
		if (!empty($config)) {
			$this->setConfig($config);
		}
	}
	
	/**
	 * 设置缓存信息
	 * @param string $config
	 * @return \Trojanbox\Cache\File\FileCacheBackend
	 */
	final public function setConfig($config = null) {
		
		foreach ($this->_defaultConfig as $key => $value) if (array_key_exists($key, $config)) {
			$configStruct[$key] = $config[$key];
		} else {
			$configStruct[$key] = $this->_defaultConfig[$key];
		}

		$this->_config = $configStruct;
		
		if (!is_dir($this->_config['directory']))
			throw new DirectoryNotFoundException("缓存目录 " . $this->_config['directory'] . " 目录不存在");
		
		return $this;
	}
	
	/**
	 * 检查缓存文件是否存在
	 * @param unknown $name
	 * @throws CacheBackendException
	 * @return mixed|boolean
	 */
	final public function exist($name) {
		if ($name == null) {
			throw new CacheBackendException("没有设置缓存名称");
		}
		
		$fileName = strtoupper($this->_config['tag'] . md5($name));
		
		if (is_file($this->_config['directory'] . $fileName)) {
			return true;
		}
		return false;
	}
	
	/**
	 * 保存缓存
	 * @param unknown $name
	 * @param unknown $content
	 * @param string $tag
	 * @throws CacheFrontedException
	 * @return \Trojanbox\Cache\Backend\FileCacheBackend
	 */
	final public function save($name, $content, $tag = null, $time = null) {
		
		if ($name == null) {
			throw new CacheFrontedException("没有设置缓存名称");
		}
		if ($content == null) {
			throw new CacheFrontedException("没有设置缓存内容");
		}
		
		$data['name'] = $name;
		$data['lifecycle'] = (strtotime(date('Ymd His')) + (int)$time);
		$data['content'] = $content;
		
		$data['time'] = (empty($time)) ? $this->_config['time'] : $time ;
		$data['state'] = ($data['time'] == 0) ? false : true; 
		$fileName = empty($tag) ? strtoupper($this->_config['tag'] . md5($name)) : strtoupper($tag . md5($name));
		
		$filePoint = fopen($this->_config['directory'] . $fileName, 'w+');
		fwrite($filePoint, serialize($data));
		fclose($filePoint);
		
		return $this;
	}
	
	/**
	 * 获取缓存
	 * @param unknown $name
	 * @throws CacheBackendException
	 * @return mixed
	 */
	final public function load($name) {
		
		if ($name == null) {
			throw new CacheBackendException("没有设置缓存名称");
		}
		
		$fileName = strtoupper($this->_config['tag'] . md5($name));
		$fileContent = file_get_contents($this->_config['directory'] . $fileName);
		$fileArray = unserialize($fileContent);
			
		$now = strtotime(date('Ymd His'));
			
		if ($fileArray['time'] != 0 && $fileArray['lifecycle'] + $fileArray['time'] < $now) {
			$this->Filectime = filectime($this->_config['directory'] . $fileName);
		}
			
		return $fileArray['content'];
	}
	
	/**
	 * 文件删除
	 * @param unknown $name
	 * @throws CacheBackendException
	 * @return boolean
	 */
	final public function remove($name) {
		if ($name == null) {
			throw new CacheBackendException("没有设置缓存名称");
		}
		$fileName = strtoupper($this->_config['tag'] . md5($name));
		if ($this->exist($fileName) && unlink($this->_config['directory'] . $fileName)) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * 删除全部缓存
	 */
	final public function removeAll() {
		$dirHandle = opendir($this->_config['directory']);
		while (false !== ($fileName = readdir($dirHandle))) {
			if (is_file($this->_config['directory'] . $fileName)) {
				if (unlink($this->_config['directory'] . $fileName)) return true;
				return false;
			}
		}
	}
	
	/**
	 * 删除过期缓存
	 */
	final public function removeOld() {

	}
}





