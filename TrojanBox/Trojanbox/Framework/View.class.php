<?php
namespace Trojanbox\Framework;

class View {
	
	protected $globals;
	
	public function __construct() {
		$this->globals = \Trojanbox\Globals\Loader::getInstance();
		$globalsControllerLists = $this->globals->get('V');
		foreach ($globalsControllerLists as $key => $value) $this->{$key} = $value;
	}
	
	public function display($fileName = null) {
		if (empty($fileName)) $fileName = $this->globals->get['_core_']['all'][2];
		$fileName = strtolower($fileName) . '.html';
		$viewPath = APP_APPLICATION_VIEW . ucfirst($this->globals->get['_core_']['all'][0]) . DIRECTORY_SEPARATOR . ucfirst($this->globals->get['_core_']['all'][1]) . DIRECTORY_SEPARATOR;
		if (!is_dir($viewPath)) throw new \Exception('没有找到视图路径 VIEW: ' . $viewPath . DIRECTORY_SEPARATOR);
		if (!is_file($viewPath . $fileName))  throw new \Exception('没有找到视图路径 VIEW: ' . $viewPath . DIRECTORY_SEPARATOR . $fileName);
		include $viewPath . $fileName;
	}
}