<?php
namespace Trojanbox\Socket;

use Trojanbox\Socket\SocketInterface\SocketAcceptInterface;
use Trojanbox\Socket\SocketInterface\SocketInterface;
use Trojanbox\Socket\Exception\SocketException;

class SocketAccept implements SocketAcceptInterface
{

    private $_socket = null;

    private $_socketAccept = null;

    /**
     * 构造 Socket Accept 对象
     * 
     * @param SocketInterface $socket            
     */
    public function __construct(SocketInterface $socket, $socketAccept)
    {
        $this->_socket = $socket;
        $this->_socketAccept = $socketAccept;
    }

    public function write($content, $length = null)
    {
        if ($length == null) {
            $length = strlen($content);
        }
        if (false === socket_write($this->_socketAccept, $content, $length)) {
            throw new SocketException($this->_socket->getSocketHandle()->getLastError());
        }
        return true;
    }

    public function read($length = 1024)
    {
        if (false === ($read = socket_read($this->_socketAccept, $length))) {
            throw new SocketException($this->_socket->getSocketHandle()->getLastError());
        }
    }
}