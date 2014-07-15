<?php
namespace Trojanbox\Event\EventInterface;

interface ListenerInterface {
	
	/**
	 * 禁用监视
	 */
	public function disableListener();
	
	/**
	 * 启用监视
	 */
	public function enableListener();
	
	/**
	 * 添加事件
	 * @param string $eventName 事件名称
	 * @param EventInterface $event 事件对象
	 */
	public function addEventHandle($eventName, EventInterface $event);
	
	/**
	 * 移除事件
	 * @param string $eventName 事件名称
	 */
	public function removeEventHandle($eventName);
	
	/**
	 * 获取事件列表
	 */
	public function getEventHandles();
	
	/**
	 * 执行指定事件
	 * @param string $eventName 事件名称
	 */
	public function executeEvent($eventName);
}