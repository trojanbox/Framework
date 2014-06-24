<?php
namespace Trojanbox\Cache\CacheInterface;

interface CacheFrontedInterface {
	
	/**
	 * 设置缓存核心
	 * @param CacheCoreInterface $cacheCore
	 */
	public function setCacheCore(CacheCoreInterface $cacheCore);

	/**
	 * 设置缓存后端
	 * @param CacheBackendInterface $cacheBackend
	 */
	public function setCacheBackend(CacheBackendInterface $cacheBackend);
	
}
