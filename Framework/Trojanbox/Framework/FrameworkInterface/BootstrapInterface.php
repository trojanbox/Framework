<?php
namespace Framework\Trojanbox\Framework;

use Trojanbox\WebApplication;

interface BootstrapInterface
{
    /**
     * 引导驱动程序
     * @param WebApplication $app
     */
    public function boot(WebApplication $app);
}