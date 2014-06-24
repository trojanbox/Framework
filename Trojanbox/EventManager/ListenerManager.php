<?php
namespace Trojanbox\EventManager;

use Trojanbox\Framework\ApplicationErrorException;
use Trojanbox\EventManager\Exception\EventManagerException;
class ListenerManager {
	
	private $_eventListener = null;
	
	public function __construct(EventListener $eventListener, $string) {
		
		if (!array_key_exists($string, $eventListener->_arrayConfig)) return ;
		
		// 创建自定义监视器
		foreach ($eventListener->_arrayConfig[$string] as $key => $value) {
			$this->$key = $eventListener->_arrayConfig[$string][$key];
		}
		
		$this->_eventListener = $eventListener;
	}
	
	/**
	 * 执行事件驱动
	 * @param unknown $prevEvent
	 * @throws ListenerException
	 */
	private function execEvent($prevEvent) {
		
		// 未启用事件驱动
		if (EventManager::$state == false) {
			return ;
		}
		
		try {
			foreach ($this->$prevEvent as $value) {
				
				$eventInfo = $this->_eventListener->_eventManager->getEventName($value['event']);
				$event = new \ReflectionClass($eventInfo['class']);
					
				if (empty($value['params'])) {
					$value['params'] = $eventInfo['params'];
				}
					
				$event = new EventProxy($value['event'], $event->newInstanceArgs($value['params']));
				$event->handle();
			}
		} catch (ApplicationErrorException $e) {	// 如果指定监听不存在则返回false
			return false;
		} catch (\ReflectionException $e) {
			throw new EventManagerException('事件驱动不存在[' . $value['event'] . ']！');
		}
	}
	
	/**
	 * 设置挂钩点
	 * @param unknown $hook
	 */
	public function setHook($hook) {
		$this->execEvent($hook);
		return $this;
	}
}