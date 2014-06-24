<?php
namespace Trojanbox\Cache\Fronted;

use Trojanbox\Cache\CacheInterface\CacheCoreInterface;
use Trojanbox\Cache\CacheInterface\CacheBackendInterface;
use Trojanbox\Cache\CacheInterface\CacheFrontedInterface;
use Trojanbox\Cache\Exception\CacheFrontedException;
use Trojanbox\Cache\CacheCore;

/**
 * 文件缓存前端
 * @author Administrator
 *
 */
class BasicCacheFronted implements CacheFrontedInterface {
	
	private $_cacheCore = null;
	private $_cacheBackend = null;
	
	/**
	 * 获取缓存
	 * @param unknown $name
	 * @throws CacheFrontedException
	 * @return string | null
	 */
	public function load($name) {
		if ($name == null) throw new CacheFrontedException("没有设置缓存名称");
		if ($this->_cacheBackend->exist($name)) {
			return $this->_cacheBackend->load($name);
		}
		return null;
	}
	
	/**
	 * 保存缓存
	 * @param unknown $name
	 * @param unknown $content
	 * @param string $tag
	 * @return string | null
	 */
	public function save($name, $content, $tag = null) {
		return $this->_cacheBackend->save($name, $content, $tag);
	}
	
	/**
	 * 缓存删除
	 * @param unknown $name
	 * @throws CacheFrontedException
	 * @return string | null
	 */
	public function remove($name) {
		if ($name == null) throw new CacheFrontedException("没有设置缓存名称");
		switch ($name) {
			case CacheCore::CLEANING_CACHE_ALL:
				
				break;
			case CacheCore::CLEANING_CACHE_OLD:
				
				break;
			default:
				return $this->_cacheBackend->remove($name);
				break;
		}
	}

	public function setCacheCore(CacheCoreInterface $cacheCore) {
		$this->_cacheCore = $cacheCore;
		return $this;
	}
	
	public function setCacheBackend(CacheBackendInterface $cacheBackend) {
		$this->_cacheBackend = $cacheBackend;
		return $this;
	}
	
}