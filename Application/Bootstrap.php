<?php
namespace Application;

use Framework\Trojanbox\Framework\FrameworkInterface;
use Trojanbox\Di\DiConfig;
use Trojanbox\Di\DiManager;
use Application\Event\LoaderEvent;
use Trojanbox\WebApplication;

class Bootstrap implements FrameworkInterface
{
	/* (non-PHPdoc)
     * @see \Framework\Trojanbox\Framework\FrameworkInterface::boot()
     */
    public function boot(WebApplication $app)
    {
        // 注册加载事件
        $app->globals->listener->onBeginRequest->addEventHandle(new LoaderEvent('LoaderEvent'));
        
        $config = include WORKSPACE . 'System' . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'DiConfig.php';
        $diConfig = DiConfig::of(new DiManager(), $config);
        $diConfig->di->capsule;
    }
}