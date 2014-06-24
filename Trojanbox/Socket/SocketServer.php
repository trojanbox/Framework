<?php
namespace Trojanbox\Socket;

use Trojanbox\Socket\SocketInterface\SocketServerInterface;
use Trojanbox\Socket\Exception\SocketServerException;
use Trojanbox\Socket\SocketInterface\SocketInterface;

class SocketServer implements SocketInterface, SocketServerInterface {

	private $_socket = null;
	
	/**
	 * 构建Socket服务器
	 * @param unknown $domain
	 * @param unknown $type
	 * @param unknown $protocol
	 */
	public function __construct($domain = SocketServer::AF_INET, 
			$type = SocketServer::SOCK_STREAM, $protocol = SocketServer::SOL_TCP) {
		$this->_socket = socket_create($domain, $type, $protocol);
	}
	
	/**
	 * 绑定
	 * @param unknown $address
	 * @param string $port
	 * @throws SocketServerException
	 */
	public function bind($address, $port, $listen) {
		if (false === socket_bind($this->_socket, $address, $port)) {
			throw new SocketServerException($this->getLastError());
		}
		
		if (false === socket_listen($this->_socket, $listen)) {
			throw new SocketServerException($this->getLastError());
		}
		
	}
	
	/**
	 * 获取Socket最后一条错误信息
	 * @return string
	 */
	public function getLastError() {
		return socket_strerror(socket_last_error($this->_socketAccept));
	}
	
	/**
	 * 获取socket句柄
	 */
	public function getSocketHandle() {
		return $this->_socket;
	}
	
	
}