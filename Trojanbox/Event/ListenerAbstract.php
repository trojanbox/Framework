<?php
namespace Trojanbox\Event;

use Trojanbox\Event\EventInterface\ListenerInterface;
use Trojanbox\Event\Exception\EventException;

abstract class ListenerAbstract implements ListenerInterface, \Iterator, \ArrayAccess
{

    protected $_listenerName;

    protected $_eventLists = array();

    protected $_listenerState = true;

    public function getName()
    {
        return $this->_listenerName;
    }

    public function disableListener()
    {
        $this->_listenerState = false;
        return $this;
    }

    public function enableListener()
    {
        $this->_listenerState = true;
        return $this;
    }

    public function removeEventHandle($eventName)
    {
        unset($this->_eventLists[$eventName]);
    }

    public function existEvent($eventName)
    {
        return array_key_exists($eventName, $this->_eventLists);
    }

    public function getEventHandles()
    {
        return $this->_eventLists;
    }

    public function executeEvents()
    {
        if (empty($this->_eventLists))
            return;
        foreach ($this->_eventLists as $value) {
            $value->handle();
        }
    }

    public function addEventHandle(EventAbstract $event)
    {
        $this->_eventLists[$event->getName()] = $event;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->_eventLists)) {
            return $this->_eventLists[$name];
        } else {
            throw new EventException('Not Found Event [' . $name . ']', E_WARNING);
        }
    }

    public function __set($key, EventAbstract $value)
    {
        if ($key != $value->getName()) {
            throw new EventException('Key should be equal to the event name.', E_WARNING);
        }
        $this->_eventLists[$key] = $value;
    }

    public function current()
    {
        return current($this->_eventLists);
    }

    public function next()
    {
        $this->_vaild = (false !== next($this->_eventLists));
    }

    public function key()
    {
        return key($this->_eventLists);
    }

    public function valid()
    {
        return $this->_valid;
    }

    public function rewind()
    {
        $this->vaild = (false !== reset($this->_eventLists));
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->_eventLists);
    }

    public function offsetGet($offset)
    {
        if (array_key_exists($offset, $this->_eventLists)) {
            return $this->_eventLists[$offset];
        }
    }

    public function offsetSet($offset, $value)
    {
        if (! $value instanceof EventAbstract) {
            throw new EventException('Must extends abstract Trojanbox\Event\EventAbstract, string given', E_RECOVERABLE_ERROR);
        }
        if ($offset != $value->getName()) {
            throw new EventException('Key should be equal to the event name.', E_WARNING);
        }
        $this->_eventLists[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        if (array_key_exists($offset, $this->_eventLists)) {
            unset($this->_eventLists[$offset]);
        }
    }
}