<?php
namespace Trojanbox\Framework;

use Trojanbox\Package\PackageManager;

class AutoLoader
{
    public function __construct()
    {
        spl_autoload_register(array($this, 'setModuleLoader'));
        spl_autoload_register(array($this, 'setCoreLoader'));
        spl_autoload_register(array($this, 'setPackageLoader'));
    }
    
    /**
     * 模块自动加载
     * 
     * @param string $className
     */
	public function setModuleLoader($className)
	{
	    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
	    if (is_file(APP_MODULE . $className . '.php')) {
	        include_once APP_MODULE . $className . '.php';
	    }
	}
	
	/**
	 * 核心自动加载
	 * 
	 * @param string $className
	 */
    public function setCoreLoader($className)
    {
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        if (is_file(FRAMEWORK . $className . '.php')) {
            include_once FRAMEWORK . $className . '.php';
        }
    }
    
    /**
     * 包自动加载
     * 
     * @param string $className
     */
    public function setPackageLoader($className)
    {
        if (false !== ($sourceInfo = PackageManager::getInstace()->getSource('\\' . $className))) {
            $package = 'phar://' . APP_PACKAGE . $sourceInfo['directory'] . DIRECTORY_SEPARATOR . $sourceInfo['package_name'] . '\\' . $className . '.php';
            include $package;
        }
    }
}