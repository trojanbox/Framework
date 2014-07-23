<?php
namespace Trojanbox\Event;

use Trojanbox\Event\EventInterface\BehaviorListenerInterface;

/**
 * 行为监视器
 */
class BehaviorListener extends ListenerAbstract implements BehaviorListenerInterface
{

    /**
     * 行为监视器构造器
     * 
     * @param string $listenerName
     */
    public function __construct($listenerName)
    {
        $this->_listenerName = $listenerName;
    }

    /**
     *
     * @see \Trojanbox\Event\ListenerAbstract::addEventHandle()
     */
    public function monitor()
    {
        if ($this->_listenerState == false)
            return false;
        $this->executeEvents();
    }
}