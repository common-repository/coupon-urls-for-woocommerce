<?php

namespace CouponURLs\Original\Construction\Abilities;

use CouponURLs\Original\Dependency\Abilities\Context;
use ReflectionParameter;
interface ContextFactory
{
    /**
     * @param mixed $value
     */
    public function create($value) : Context;
}