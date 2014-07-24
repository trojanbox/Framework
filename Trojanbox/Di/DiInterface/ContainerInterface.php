<?php
namespace Trojanbox\Di\DiInterface;

use Trojanbox\Di\Di;

interface ContainerInterface
{

    public function __construct(Di $di);
}