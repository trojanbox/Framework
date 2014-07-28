<?php
namespace Trojanbox\Event\EventInterface;

use Trojanbox\Event\EventAbstract;

interface ListenerInterface
{

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
     * 
     * @param string $eventName
     * @param EventInterface $event
     */
    public function addEventHandle(EventAbstract $event);

    /**
     * 移除事件
     * 
     * @param string $eventName
     */
    public function removeEventHandle($eventName);

    /**
     * 事件是否存在
     * 
     * @param string $eventName
     */
    public function hasEvent($eventName);

    /**
     * 获取事件列表
     */
    public function getEventHandles();

    /**
     * 执行事件
     * 
     * @param string $eventName
     */
    public function executeEvents();

    /**
     * 取得监视器名称
     */
    public function getName();
}