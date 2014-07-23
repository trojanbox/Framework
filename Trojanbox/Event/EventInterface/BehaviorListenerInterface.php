<?php
namespace Trojanbox\Event\EventInterface;

interface BehaviorListenerInterface extends ListenerInterface
{

    /**
     * 创建行为监视器
     * 
     * @param string $listenerName
     *            监视器名称
     */
    public function __construct($listenerName);

    /**
     * 启用监视器
     */
    public function monitor();
} 