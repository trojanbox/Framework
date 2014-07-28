<?php
namespace Trojanbox\Di\DiInterface;

use Trojanbox\Di\DiManager;

interface ContainerInterface
{

    public function __construct(DiManager $di);
}