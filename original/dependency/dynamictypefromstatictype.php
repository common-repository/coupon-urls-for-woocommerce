<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Dependency\Abilities\DynamicType;
use CouponURLs\Original\Dependency\Abilities\StaticType;
class DynamicTypeFromStaticType implements DynamicType
{
    /**
     * @var string
     */
    protected $staticType;
    public function __construct(string $staticType)
    {
        $this->staticType = $staticType;
    }
    public function type() : string
    {
        return $this->staticType::type();
    }
    public function defaultType() : string
    {
        return $this->staticType;
    }
}