<?php
namespace Trojanbox\Event;

use Trojanbox\Event\EventInterface\ListenerInterface;
use Trojanbox\Event\Exception\ListenerManagerException;

class ListenerManager implements \Iterator, \ArrayAccess
{

    private $_listenerLists = array();

    private static $_self;

    private $_vaild = true;

    private function __construct()
    {}

    /**
     * 取得监听管理器的实例
     * 
     * @return \Trojanbox\Event\ListenerManager
     */
    public static function getInstance()
    {
        if (! self::$_self instanceof self) {
            self::$_self = new self();
        }
        return self::$_self;
    }

    /**
     * 注册到监听管理器
     * 
     * @param ListenerInterface $listener            
     */
    public function registerListener(ListenerInterface $listener)
    {
        $this->_listenerLists[$listener->getName()] = $listener;
    }

    /**
     * 移除指定监视器
     * 
     * @param string $listenerName
     */
    public function removeListener($listenerName)
    {
        unset($this->_listenerLists[$listenerName]);
    }

    /**
     * 取得监视器列表
     */
    public function getListeners()
    {
        return $this->_listenerLists;
    }

    /**
     * 取得指定监视器
     * 
     * @param string $listenerName
     */
    public function getListener($listenerName)
    {
        return $this->_listenerLists[$listenerName];
    }

    /**
     * 判断监视器是否存在
     * 
     * @param string $listenerName
     */
    public function hasListener($listenerName)
    {
        return array_key_exists($listenerName, $this->_listenerLists);
    }

    /**
     * 预处理器 - 自动加载配置文件中的设置
     * 
     * @param array $array
     */
    public function prepare($array)
    {}

    public function __get($name)
    {
        if (array_key_exists($name, $this->_listenerLists)) {
            return $this->_listenerLists[$name];
        } else {
            throw new ListenerManagerException('Not Found Listener [' . $name . ']', E_WARNING);
        }
    }

    public function __set($key, ListenerInterface $value)
    {
        if ($key != $value->getName()) {
            throw new ListenerManagerException('Key should be equal to the listener name.', E_WARNING);
        }
        $this->_listenerLists[$key] = $value;
    }

    public function current()
    {
        return current($this->_listenerLists);
    }

    public function next()
    {
        $this->_vaild = (false !== next($this->_listenerLists));
    }

    public function key()
    {
        return key($this->_listenerLists);
    }

    public function valid()
    {
        return $this->_valid;
    }

    public function rewind()
    {
        $this->vaild = (false !== reset($this->_listenerLists));
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->_listenerLists);
    }

    public function offsetGet($offset)
    {
        if (array_key_exists($offset, $this->_listenerLists)) {
            return $this->_listenerLists[$offset];
        }
    }

    public function offsetSet($offset, $value)
    {
        if (! $value instanceof ListenerInterface) {
            throw new ListenerManagerException('Must implement interface Trojanbox\Event\EventInterface\ListenerInterface, string given', E_RECOVERABLE_ERROR);
        }
        if ($offset != $value->getName()) {
            throw new ListenerManagerException('Key should be equal to the listener name.', E_WARNING);
        }
        $this->_listenerLists[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        if (array_key_exists($offset, $this->_listenerLists)) {
            unset($this->_listenerLists[$offset]);
        }
    }
}