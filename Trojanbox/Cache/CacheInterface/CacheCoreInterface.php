<?php
namespace Trojanbox\Cache\CacheInterface;

use Trojanbox\Cache\CacheInterface\CacheFrontedInterface;
use Trojanbox\Cache\CacheInterface\CacheBackendInterface;

interface CacheCoreInterface
{

    function __construct(CacheFrontedInterface $cacheFronted, CacheBackendInterface $cacheBackend);
}