<?php
namespace Trojanbox\Package;

class CreateExtendPackage {

	private $phar = null;
	private $currectDirectory = null;
	private $PHAR_INFO = array();
	private $goalFile = null;

	/**
	 * 扩展打包
	 * @param unknown $goalFile 文件名称 保存到
	 * @param unknown $sourceDirectory 资源文件
	 */
	public function __construct($goalFile, $sourceDirectory) {
		$this->goalFile = $goalFile . '.phar';
		$this->goalFileName = basename($this->goalFile);
		$this->phar = new \Phar($this->goalFile, 0, $this->goalFileName);
		$this->currectDirectory = $sourceDirectory;

		// 整理文件结构
		$this->getFileInfo($sourceDirectory);
	}

	/**
	 * 获取目录结构信息
	 * @param unknown $sourceDirectory
	 */
	private function getFileInfo($sourceDirectory) {
		$directoryIterator = new \DirectoryIterator($sourceDirectory);
		while ($directoryIterator->valid()) {
			if ($directoryIterator->getFilename() == '..'
				|| $directoryIterator->getFilename() == 'PHAR_INFO'
				|| $directoryIterator->getFilename() == '.') {
				$directoryIterator->next();
				continue;
			}
			switch ($directoryIterator->getType()) {
			case 'file':
				$this->PHAR_INFO['class_lists'][str_replace($this->currectDirectory, '', $directoryIterator->getRealPath())] =  $this->goalFileName;
				break;
			case 'dir':
				$this->getFileInfo($directoryIterator->getRealPath());
				break;
			}
			$directoryIterator->next();
		}
	}

	/**
	 * 设置版本信息
	 * @param unknown $value
	 * @return \Trojanbox\Package\CreateExtendPageage
	 */
	public function setVersion($value) {
		$this->setAttribute('version', $value);
		return $this;
	}

	/**
	 * 设置作者名称
	 * @param unknown $value
	 * @return \Trojanbox\Package\CreateExtendPageage
	 */
	public function setAuthor($value) {
		$this->setAttribute('author', $value);
		return $this;
	}

	/**
	 * 设置描述信息
	 * @param unknown $value
	 * @return \Trojanbox\Package\CreateExtendPageage
	 */
	public function setDescription($value) {
		$this->setAttribute('description', $value);
		return $this;
	}

	/**
	 * 帮助链接地址
	 * @param unknown $value
	 * @return \Trojanbox\Package\CreateExtendPageage
	 */
	public function setSee($value) {
		$this->setAttribute('see', $value);
		return $this;
	}

	/**
	 * 设置属性
	 * @param unknown $key
	 * @param unknown $value
	 * @return \Trojanbox\Package\CreateExtendPageage
	 */
	public function setAttribute($key, $value) {
		$this->PHAR_INFO['extend_info'][$key] = $value;
		return $this;
	}

	/**
	 * 资源打包处理
	 */
	public function uppack() {
		$this->phar->buildFromDirectory($this->currectDirectory);		
		$this->phar->setStub("<?php Phar::mapPhar(); return '" . serialize($this->PHAR_INFO) . "'; __HALT_COMPILER();");
	}

}