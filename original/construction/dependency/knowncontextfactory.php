<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Construction\Abilities\ContextFactory;
use CouponURLs\Original\Construction\Abilities\OverloadableFactory;
use CouponURLs\Original\Dependency\Abilities\Context;
use CouponURLs\Original\Dependency\KnownContext;
use function CouponURLs\Original\Utilities\Text\i;
use ReflectionParameter;
class KnownContextFactory implements ContextFactory, OverloadableFactory
{
    /** @param mixed $value */
    public function canCreate($value) : bool
    {
        return $value instanceof ReflectionParameter && $value->hasType() && class_exists($value->getType());
    }
    /** @param mixed $value */
    public function create($value) : Context
    {
        return new KnownContext(i($value->getDeclaringClass()->getName()), i($value->getDeclaringFunction()->getShortName()), i($value->getName()));
    }
}