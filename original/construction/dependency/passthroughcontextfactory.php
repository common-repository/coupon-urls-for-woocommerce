<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Construction\Abilities\ContextFactory;
use CouponURLs\Original\Construction\Abilities\OverloadableFactory;
use CouponURLs\Original\Dependency\Abilities\Context;
class PassThroughContextFactory implements ContextFactory, OverloadableFactory
{
    /**
     * @param mixed $value
     */
    public function canCreate($value) : bool
    {
        return $value instanceof Context;
    }
    /** @param mixed $value */
    public function create($value) : Context
    {
        return $value;
    }
}