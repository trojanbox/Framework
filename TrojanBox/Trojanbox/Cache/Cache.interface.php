<?php
namespace Trojanbox\Cache;

/**
 * XML 解析器 通用编程接口
 * @author Administrator
 *
 */
interface CacheInterface {
	
	/**
	 * 获取缓存
	 * @param string $name 缓存名称
	 */
	function getCache($name = null);
	
	/**
	 * 创建文件缓存
	 * @param string $name 缓存名称
	 * @param string $content 缓存内容
	 * @param string $time 缓存时间
	 */
	function setCache($name = null, $content = null, $time = null);
	
	/**
	 * 配置文件
	 * @param string $config
	 */
	function setConfig($config = null);
	
	/**
	 * 删除缓存
	 * @param string $name
	 */
	function delCache($name = null);

	/**
	 * 删除全部缓存
	 */
	function delAll();
}
