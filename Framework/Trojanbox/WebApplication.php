<?php
namespace Trojanbox;

use Trojanbox\Config\ArrayConfig;
use Trojanbox\File\File;
use Trojanbox\Exception\ErrorExceptionHandle;
use Trojanbox\Framework\Framework;
use Trojanbox\Framework\AutoLoader;

require_once 'Framework' . DIRECTORY_SEPARATOR . 'Framework.php';

class WebApplication extends Framework
{

    public function __construct()
    {
        define('FRAMEWORK', WORKSPACE . 'Framework' . DIRECTORY_SEPARATOR);
        $this->setDefine();
        $autoloader = new AutoLoader();
        ErrorExceptionHandle::setExceptionHandle();
        ErrorExceptionHandle::setErrorHandle();
        ErrorExceptionHandle::setFatalErrorHandle();
        parent::__construct();
    }
    
    /**
	/* 全局引导层
	 * 
	 * @param \Closure $func
	 * @return \Trojanbox\WebApplication
	 */
	public function bootstrap($func) {
		// TODO: Auto-generated method stub
        $func($this);
        return $this;
	}
    
    /**
     * 执行
     */
    public function run()
    {
        try {
            $this->activate()->letsGo();
        } catch (\PageNotFoundException $e) {
            $config = new ArrayConfig(new File(WORKSPACE . 'System' . DS . 'Config' . DS . 'ExceptionTemplate.php'));
            $pageNotFound = $config->getConfig('page not found');
            $pageNotFound();
        }
    }
}