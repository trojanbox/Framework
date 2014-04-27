<?php
namespace Trojanbox\Globals;

class Loader {
	private static $only = null;
	private $url = null;
	private $state = null;
	public $a = null;

	/**
	 * 全局对象
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

	/**
	 * 创建唯一全局对象
	 * @return \Trojanbox\Globals\Loader
	 */
	public static function getInstance() {
		if (!is_object(self::$only)) {
			self::$only = new self();
		}
		return self::$only;
	}

	/**
	 * 将对象部署到框架核心。<br>在 Model, View, Controller可通过 $this->globals->$(name) 调用装入的指定对象
	 * @param $name 对象别名
	 * @param $objcet 有效对象
	 * @param $mvc 有效范围 默认MVC
	 * @return $this;
	 */
	public function set($name, $objcet, $mvc = 'MVC') {
		if (empty($name) || empty($mvc)) throw new \Exception(__METHOD__ . '不接受空参数！');
		$mvc = strtoupper($mvc);
		$mvcLen = strlen($mvc);
		for ($i = 0; $i < $mvcLen; $i++) {
			switch ($mvc{$i}) {
				case 'M':
					$this->state['_M'][$name] = $objcet;
					break;
				case 'V':
					$this->state['_V'][$name] = $objcet;
					break;
				case 'C':
					$this->state['_C'][$name] = $objcet;
					break;
				default:
					throw new \Exception(__METHOD__ . '不接受除MVC外的未知参数！');
					break;
			}
		}

		$this->$name = $objcet;
		return $this;
	}
	
	/**
	 * 获取全局对象中的类型对象数组
	 * @param string $mvc 接受参数MVC 只接受单一字母
	 * @throws \Exception
	 */
	public function get($mvc = null) {
		if (empty($mvc)) return $this->state;
		$mvc = strtoupper($mvc);
		switch ($mvc{0}) {
			case 'M':
				return $this->state['_M'];
				break;
			case 'V':
				return $this->state['_V'];
				break;
			case 'C':
				return $this->state['_C'];
				break;
			default:
				throw new \Exception(__METHOD__ . '不接受除MVC外的未知参数！');
				break;
		}
	}
}