<?php

namespace CouponURLs\Original\Construction\Abilities;

use CouponURLs\Original\Dependency\Container;
use CouponURLs\Original\Dependency\Dependency;
interface ContainerFactory
{
    /**
     * @param string|\CouponURLs\Original\Dependency\Dependency $dependency
     */
    public function create($dependency) : Container;
}