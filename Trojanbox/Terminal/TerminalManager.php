<?php
namespace Trojanbox\Terminal;

use Trojanbox\Terminal\Exception\TerminalException;
use Trojanbox\Terminal\TerminalInterface\TerminalManagerInterface;

class TerminalManager implements TerminalManagerInterface
{

    private $tMode = null;

    private $tArgs = null;

    private $tName = null;

    private $tArgsStruct = null;

    private $tRunState = false;

    private $tString = null;

    const SCP = 'SWITCH_COMMAND_PARAMETERS';

    const BSCP = 'BASIC_SWITCH_COMMAND_PARAMETERS';

    /**
     * Terminal 适配器
     *
     * @param string $string            
     * @param unknown $mode            
     * @throws TerminalException
     * @return \Trojanbox\Terminal\TerminalManager boolean
     */
    public function cmd($string = null, $mode = self::SCP)
    {
        if (empty($string))
            throw new TerminalException('Terminal 适配器需要一个String参数！');
        if (in_array($mode, array(
            self::SCP,
            self::BSCP
        ))) {
            $this->tMode = $mode;
            $this->tString = $string;
            return $this;
        }
        throw new TerminalException('无法识别的命令提示符模式。');
    }

    /**
     * 获取命令名称
     *
     * @throws TerminalException
     * @return boolean
     */
    public function getCommandName()
    {
        if (! $this->tRunState)
            $this->coreResolver($this->tString);
        if (! empty($this->tName)) {
            return $this->tName;
        }
        return false;
    }

    /**
     * 获取参数开关
     *
     * @param string $key            
     * @throws TerminalException
     * @return boolean
     */
    public function key($key = null)
    {
        if (empty($key))
            throw new TerminalException('Terminal Key 需要一个参数开关！');
        if (! $this->tRunState)
            $this->coreResolver($this->tString);
        
        switch ($this->tMode) {
            case self::SCP:
                return $this->linuxResolver($key);
                break;
            default:
                throw new TerminalException('无法识别的命令提示符模式。');
                return false;
        }
    }

    /**
     * 命令解析器
     *
     * @param unknown $string            
     * @return \Trojanbox\Terminal\TerminalManager
     */
    private function coreResolver($string)
    {
        $this->tArgs = explode(' ', $string);
        $this->tName = $this->tArgs[0];
        unset($this->tArgs[0]);
        $this->tArgs = array_merge($this->tArgs);
        $tArgsCount = count($this->tArgs);
        for ($i = 0; $i < $tArgsCount; $i += 2)
            $this->tArgsStruct[$this->tArgs[$i]] = $this->tArgs[$i + 1];
        return $this;
    }

    /**
     * Linux Terminal 解析器
     *
     * @param unknown $key            
     * @return boolean
     */
    private function linuxResolver($key)
    {
        if (empty($this->tArgsStruct))
            return false;
        
        if (array_key_exists($key, $this->tArgsStruct))
            return $this->tArgsStruct[$key];
        
        return false;
    }
}



