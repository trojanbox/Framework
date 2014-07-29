<?php
namespace Trojanbox\Event\EventInterface;

interface TriggerListenerInterface
{

    /**
     * 创建触发监视器
     *
     * @param string $listenerName            
     * @param string $triggerString            
     */
    public function __construct($listenerName, $triggerString);

    /**
     * 启用监视
     *
     * @param string $triggerString            
     */
    public function monitor($triggerString);
}