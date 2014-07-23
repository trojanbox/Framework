<?php
namespace Trojanbox\File;

use Trojanbox\File\FileInterface\InputStreamInterface;
use Trojanbox\File\FileInterface\FileInterface;
use Trojanbox\File\Exception\InputStreamException;

class Writer implements InputStreamInterface
{

    /**
     * 追加写入
     */
    const FILE_ADD = 1;

    /**
     * 覆盖写入
     */
    const FILE_WRITE = 2;

    private $_file;

    private $_fileHandle;

    /**
     * 构造输入流
     * 
     * @param FileInterface $file            
     */
    public function __construct(FileInterface $file, $mode = Writer::FILE_WRITE)
    {
        $this->_file = $file;
        switch ($mode) {
            case Writer::FILE_WRITE:
                $this->_fileHandle = fopen($file->getFile(), 'w+');
                break;
            case Writer::FILE_ADD:
                $this->_fileHandle = fopen($file->getFile(), 'a+');
                break;
            default:
                throw new InputStreamException('文件操作模式不正确');
        }
    }

    /**
     * 写入内容
     * 
     * @param unknown $content            
     * @param string $length            
     */
    public function write($content, $length = null)
    {
        if ($length == null) {
            fwrite($this->_fileHandle, $content);
        } else {
            fwrite($this->_fileHandle, $content, $length);
        }
    }

    /**
     * 关闭输入流
     * 
     * @return boolean
     */
    public function close()
    {
        return fclose($this->_fileHandle);
    }
}