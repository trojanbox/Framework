<?php
namespace Trojanbox\Cache;

use Trojanbox\Cache\CacheInterface\CacheFrontedInterface;
use Trojanbox\Cache\CacheInterface\CacheBackendInterface;
use Trojanbox\Cache\CacheInterface\CacheCoreInterface;

/**
 * 缓存核心组件
 * 
 * @author Administrator
 *        
 */
class CacheCore implements CacheCoreInterface
{

    /**
     * 全部缓存
     */
    const CLEANING_CACHE_ALL = 1;

    /**
     * 过期缓存
     */
    const CLEANING_CACHE_OLD = 2;

    /**
     * 过期缓存
     */
    const CLEANING_CACHE_TAG = 3;

    private $_cacheFronted = null;

    private $_cacheBackend = null;

    /**
     * 创建文件缓存对象
     * 
     * @param CacheFrontedInterface 缓存前端控制器
     * @param CacheBackendInterface 缓存后端控制器
     */
    public function __construct(CacheFrontedInterface $cacheFronted, CacheBackendInterface $cacheBackend)
    {
        $this->_cacheFronted = $cacheFronted;
        $this->_cacheBackend = $cacheBackend;
        $this->_cacheFronted->setCacheBackend($this->_cacheBackend);
        $this->_cacheFronted->setCacheCore($this);
    }

    public function run()
    {
        return $this->_cacheFronted;
    }
}