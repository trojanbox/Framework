<?php
namespace Trojanbox\Framework;

class Globals implements \Iterator, \ArrayAccess {
	
	private static $_self = null;
	private $url = null;
	private $_globals = array();
	private $_vaild = true;
	
	/**
	 * 全局构造器
	 */
	private function __construct() {
		$this->set('post', empty($_POST) ? array() : $_POST);
		$this->set('session', empty($_SESSION) ? array() : $_SESSION);
		$this->set('server', empty($_SERVER) ? array() : $_SERVER);
		$this->set('cookie', empty($_COOKIE) ? array() : $_COOKIE);
		$this->set('env', empty($_ENV) ? array() : $_ENV);
		$this->set('request', empty($_REQUEST) ? array() : $_REQUEST);
		$this->set('files', empty($_FILES) ? array() : $_FILES);
	}

	public static function getInstance() {
		if (!self::$_self instanceof self) {
			self::$_self = new self();
		}
		return self::$_self;
	}

	/**
	 * 设置全局对象
	 * @param string $name
	 * @param other $objcet
	 * @return multitype:
	 */
	public function set($name, $objcet) {
		$this->_globals[$name] = $objcet;
		return $this;
	}

	/**
	 * 获取全局对象
	 * @param unknown $name
	 * @throws \FrameworkException
	 */
	public function get($name) {
		if (array_key_exists($name, $this->_globals)) {
			return $this->_globals[$name];
		} else {
			throw new \FrameworkException('Not Found Globals ' . $name . '.', E_WARNING);
		}
	}

	public function exist($name) {
		return array_key_exists($name, $this->_globals);
	}
	
	public function __set($name, $value) {
		return $this->set($name, $value);
	}

	public function __get($name) {
		return $this->get($name);
	}
	
	public function current() {
		return current($this->_globals);
	}

	public function next() {
		$this->_vaild = (false !== next($this->_globals));
	}

	public function key() {
		return key($this->_globals);
	}

	public function valid() {
		return $this->_vaild;
	}

	public function rewind() {
		$this->vaild = (false !== reset($this->_globals));
	}

	public function offsetExists($offset) {
		return $this->exist($offset);
	}

	public function offsetGet($offset) {
		return $this->get($offset);
	}

	public function offsetSet($offset, $value) {
		return $this->set($offset, $value);
	}

	public function offsetUnset($offset) {
		if (array_key_exists($offset, $this->_globals)) {
			unset($this->_globals[$offset]);
		}
	}
}