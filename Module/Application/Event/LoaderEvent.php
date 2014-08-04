<?php
namespace Application\Event;

use Trojanbox\Event\EventAbstract;
use Trojanbox\Package\PackageManager;

class LoaderEvent extends EventAbstract
{

    public function handle()
    {
        PackageManager::setAutoLoad(true);
    }
}