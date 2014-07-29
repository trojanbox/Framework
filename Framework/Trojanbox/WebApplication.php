<?php
namespace Trojanbox;

use Trojanbox\Config\ArrayConfig;
use Trojanbox\File\File;
use Trojanbox\Exception\ErrorExceptionHandle;
use Trojanbox\Framework\Framework;
use Application\Bootstrap;
require_once 'Framework' . DIRECTORY_SEPARATOR . 'Framework.php';

class WebApplication extends Framework
{

    public function __construct()
    {
        define('FRAMEWORK', WORKSPACE . 'Framework' . DIRECTORY_SEPARATOR);
        spl_autoload_register(array(
            $this,
            'autoload'
        ));
        ErrorExceptionHandle::setExceptionHandle();
        ErrorExceptionHandle::setErrorHandle();
        ErrorExceptionHandle::setFatalErrorHandle();
        parent::__construct();
    }
    
    public function bootstrap()
    {
        $bootstrap = new Bootstrap();
        $bootstrap->boot($this);
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