<?php
namespace Trojanbox\Cache\File;

class Center implements \Trojanbox\Cache\CacheInterface {

	protected $config = null;
	private $configInfo = array('time' => '0', 'prefix' => 'file');

	public function __construct($config = null) {
		if (!empty($config)) $this->setConfig($config);
	}

	final public function setConfig($config = null) {
		foreach ($this->configInfo as $key => $value) if (array_key_exists($key, $config)) {
			$dbInfo[$key] = $config[$key];
		} else {
			$dbInfo[$key] = $this->configInfo[$key];
		}
		$this->config = $dbInfo;
		return $this;
	}

	public function setCache($name = null, $content = null, $time = null) {
		if (empty($name)) throw new \Exception('缓存名称不能为空');
		if (!is_dir(CACHE_FRAMEWORK)) throw new \Exception('缓存目录无效，请重新制定新目录');
		
		if (is_null($time)) $data['time'] = $this->config['time'];
		else $data['time'] = $time;
		
		if ($data['time'] == 0) $data['state'] = false; else $data['state'] = true;
		$data['name'] = $name;
		$data['lifecycle'] = (strtotime(date('Ymd His'))+(int)$time);
		$data['content'] = $content;
		$fileName = strtoupper($this->config['prefix'] . md5($name));
		
		$filePoint = fopen(CACHE_FRAMEWORK . $fileName, 'w+');
		fwrite($filePoint, json_encode($data));
		fclose($filePoint);
		return $this;
	}

	public function getCache($name = null) {
		if (empty($name)) throw new \Exception('缓存名称不能为空');
		$fileName = strtoupper($this->config['prefix'] . md5($name));
		if (is_file(CACHE_FRAMEWORK . $fileName)) {
			$fileContent = file_get_contents(CACHE_FRAMEWORK . $fileName);
			$fileArray = json_decode($fileContent, true);
			$now = strtotime(date('Ymd His'));
			if ($fileArray['time'] != 0)
				if ($fileArray['lifecycle']+$fileArray['time'] < $now) return false;
			return $fileArray['content'];
		} return false;
	}

	public function delCache($name = null) {
		if (empty($name)) throw new \Exception('缓存名称不能为空');
		$fileName = strtoupper($this->config['prefix'] . md5($name));
		if (is_file(CACHE_FRAMEWORK . $fileName))
			unlink(CACHE_FRAMEWORK . $fileName);
		return true;
	}
	
	public function delAll() {
		$dirHandle = opendir(CACHE_FRAMEWORK);
		while (false !== ($fileName = readdir($dirHandle))) {
			if (preg_match('/^' . $this->config['prefix'] . '/i', $fileName)) {
				if (is_file(CACHE_FRAMEWORK . $fileName))
					unlink(CACHE_FRAMEWORK . $fileName);
			}
		}
		return $this;
	}
}