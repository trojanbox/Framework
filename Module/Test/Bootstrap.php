<?php
namespace Test;

use Test\Event\LoaderEvent;
use Trojanbox\WebApplication;
use Trojanbox\Di\ServiceLocator;
use Framework\Trojanbox\Framework\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    /* (non-PHPdoc)
     * @see \Framework\Trojanbox\Framework\FrameworkInterface::boot()
     */
    public function boot(WebApplication $app)
    {
        // 注册加载事件
        ServiceLocator::listener()->onBeginRequest->addEventHandle(new LoaderEvent('LoaderEvent'));
    }
}