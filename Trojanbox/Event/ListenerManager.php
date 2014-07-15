<?php
namespace Trojanbox\Event;

use Trojanbox\Event\EventInterface\ListenerInterface;

class ListenerManager {
	
	private static $_listenerLists;
	
	/**
	 * 注册到监听管理器
	 * @param ListenerInterface $listener
	 */
	public static function registerListener(ListenerInterface $listener) {
		self::$_listenerLists[$listener->getName()] = $listener;
	}
	
	/**
	 * 移除指定监视器
	 * @param string $listenerName 监视器名称
	 */
	public static function removeListener($listenerName) {
		
	}
	
	/**
	 * 取得监视器列表
	 */
	public static function getListeners() {
		
	}
	
	/**
	 * 取得指定监视器
	 * @param string $listenerName 监视器名称
	 */
	public static function getListener($listenerName) {
		
	}
	
	/**
	 * 判断监视器是否存在
	 * @param string $listenerName 监视器名称
	 */
	public static function existListener($listenerName) {
		
	}
}