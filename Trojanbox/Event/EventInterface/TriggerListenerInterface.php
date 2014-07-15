<?php
namespace Trojanbox\Event\EventInterface;

interface TriggerListenerInterface {
	
	/**
	 * 创建触发监视器
	 * @param string $listenerName 监视器名称
	 * @param string $triggerString 触发条件
	 */
	public function __construct($listenerName, $triggerString);
	
	/**
	 * 启用监视
	 * @param string $triggerString 监视条件
	 */
	public function monitor($triggerString);
	
}