<?php
namespace Trojanbox\Event;

use Trojanbox\Event\EventInterface\TriggerListenerInterface;
use Trojanbox\Event\Exception\ListenerException;

/**
 * 触发监视器
 */
class TriggerListener extends ListenerAbstract implements TriggerListenerInterface
{

    private $_triggerString;

    /**
     * 创建触发监视器
     *
     * @param string 监听器名称
     */
    public function __construct($listenerName, $triggerString)
    {
        $this->_listenerName = $listenerName;
        $this->_triggerString = strtoupper($triggerString);
    }

    /**
     *
     * @see \Trojanbox\Event\EventInterface\TriggerListenerInterface::monitor()
     */
    public function monitor($triggerString)
    {
        if (is_null($triggerString) || ! is_string($triggerString)) {
            throw new ListenerException('触发监听器需要填写触发条件！');
        }
        if (0 == strpos($this->_listenerState, 'trigger://string=')) {
            $string = str_replace('trigger://string=', '', $this->_listenerState);
            if ($string == $triggerString) {
                $this->executeEvents();
            }
        } elseif (0 == strpos($this->_listenerState, 'trigger://preg=')) {
            $string = str_replace('trigger://preg=', '', $this->_listenerState);
            if (preg_match($string, $triggerString)) {
                $this->executeEvents();
            }
        } else {
            throw new ListenerException('无效的触发条件！');
        }
    }
}