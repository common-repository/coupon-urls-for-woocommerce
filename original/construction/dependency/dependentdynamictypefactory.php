<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Construction\Abilities\OverloadableFactory;
use CouponURLs\Original\Dependency\Abilities\DynamicType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\SameType;
class DependentDynamicTypeFactory implements OverloadableFactory
{
    /** @param mixed $value */
    public function canCreate($value) : bool
    {
        return !is_a($value, Dependency::class, true);
    }
    public function create(string $type) : DynamicType
    {
        return new SameType($type);
    }
}