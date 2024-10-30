<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Dependency\Abilities\StaticType;
class UnCachedInstanceDependencyContainer extends DependencyContainer
{
    /**
     * @var (\CouponURLs\Original\Dependency\Abilities\StaticType & \CouponURLs\Original\Dependency\Dependency)
     */
    protected $dependency;
    /**
     * @param (\CouponURLs\Original\Dependency\Abilities\StaticType & \CouponURLs\Original\Dependency\Dependency) $dependency
     */
    public function __construct($dependency)
    {
        $this->dependency = $dependency;
    }
    public function get(string $type) : object
    {
        return $this->dependency->create();
    }
}