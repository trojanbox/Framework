<?php
namespace Trojanbox\Terminal;

/**
 * Terminal Class
 *
 * com.trojanbox.extension.terminal
 */
class Terminal {

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
     */
	public function cmd($string = null, $mode = self::SCP) {
		if (empty($string)) return false;
		if (in_array($mode, array(self::SCP, self::BSCP))) {
			$this->tMode = $mode;
			$this->tString = $string;
			return $this;
		}
		return false;
	}

	public function key($key = null) {
		if (empty($key)) return false;
		if (!$this->tRunState) $this->coreResolver($this->tString);
		
		switch ($this->tMode) {
			case self::SCP:
				return $this->linuxResolver($key);
				break;
			case self::BSCP:
				$this->basicResolver($key);
				break;
			default:
				return false;
		}
	}
	
	private function coreResolver($string) {
		$this->tArgs = explode(' ', $string);
		$this->tName = $this->tArgs[0];
		unset($this->tArgs[0]);
		$this->tArgs = array_merge($this->tArgs);
		$tArgsCount = count($this->tArgs);
		for ($i = 0; $i < $tArgsCount; $i+=2)
			$this->tArgsStruct[$this->tArgs[$i]] = $this->tArgs[$i+1];
		return $this;
	}
    
    /**
     * Linux Terminal 解析器
     */
    private function linuxResolver($key) {
    	if (array_key_exists($key, $this->tArgsStruct)) return $this->tArgsStruct[$key];
    }
    
    /**
     * Basic Terminal 解析器
     */
    private function basicResolver() {
    	
    }
}



