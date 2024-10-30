<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Dependency\Abilities\DynamicType;
class SameType implements DynamicType
{
    /**
     * @var string
     */
    protected $type;
    public function __construct(string $type)
    {
        $this->type = $type;
    }
    public function type() : string
    {
        return $this->type;
    }
    public function defaultType() : string
    {
        return $this->type;
    }
}