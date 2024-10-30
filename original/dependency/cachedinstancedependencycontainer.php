<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Cache\Cache;
use CouponURLs\Original\Cache\MemoryCache;
use CouponURLs\Original\Dependency\Abilities\StaticType;
class CachedInstanceDependencyContainer extends DependencyContainer
{
    /**
     * @var (\CouponURLs\Original\Dependency\Abilities\StaticType & \CouponURLs\Original\Dependency\Dependency)
     */
    protected $dependency;
    /**
     * @var \CouponURLs\Original\Cache\Cache
     */
    protected $cache;
    /**
     * @param (\CouponURLs\Original\Dependency\Abilities\StaticType & \CouponURLs\Original\Dependency\Dependency) $dependency
     */
    public function __construct($dependency, Cache $cache = null)
    {
        $cache = $cache ?? new MemoryCache();
        $this->dependency = $dependency;
        $this->cache = $cache;
    }
    public function get(string $type) : object
    {
        return $this->cache->getIfExists('dependency')->otherwise(\Closure::fromCallable([$this->dependency, 'create']));
    }
}