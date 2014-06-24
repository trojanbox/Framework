<?php
namespace Trojanbox\EventManager;

use Trojanbox\EventManager\EventManagerInterface\EventManagerInterface;
use Trojanbox\Framework\Instance;
use Trojanbox\EventManager\EventManagerInterface\AbstractFactoryInterface;

class EventManager extends Instance implements EventManagerInterface {
	
	/** 事件驱动 状态 */
	public static $state = false;
	
	/** 事件列表 */
	private $_event = array();
	private $_arrayConfig = array();
	
	protected function __construct($config) {
		$this->_arrayConfig = $config;
	}
	
	public static function getClassName() {
		return get_class();
	}
	
	/**
	 * 配置文件
	 * @param unknown $config
	 * @return \Trojanbox\EventManager\EventManager
	 */
	public function setConfig($config) {
		$this->_arrayConfig = $config;
		return $this;
	}

	/**
	 * 根据事件名称取得事件
	 * @param unknown $name
	 * @return multitype:|boolean
	 */
	public function getEventName($name) {
		if (array_key_exists($name, $this->_arrayConfig)) {
			if (empty($this->_arrayConfig[$name]['params'])) {
				$this->_arrayConfig[$name]['params'] = array();
			}
			return $this->_arrayConfig[$name];
		}
		return false;
	}
	
	/**
	 * 添加事件
	 * @param unknown $name
	 * @param AbstractFactoryInterface $event
	 * @return \Trojanbox\EventManager\EventManager
	 */
	public function addEvent($name, AbstractFactoryInterface $event) {
		$this->_event[$name] = $event;
		return $this;
	}
	
	/**
	 * 获取事件列表
	 * @return multitype:
	 */
	public function getEventLists() {
		return $this->_arrayConfig;
	}
	
	/**
	 * 获取已注册的事件列表
	 */
	public function getRegistEventLists() {
		return $this->_event;
	}
	
}