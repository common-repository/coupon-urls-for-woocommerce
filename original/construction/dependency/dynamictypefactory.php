<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Construction\FactoryOverloader;
use CouponURLs\Original\Dependency\Abilities\DynamicType;
class DynamicTypeFactory
{
    /**
     * @var \CouponURLs\Original\Construction\FactoryOverloader
     */
    protected $factoryOverloader;
    public function __construct(FactoryOverloader $factoryOverloader)
    {
        $this->factoryOverloader = $factoryOverloader;
    }
    public function create(string $dependencyType) : DynamicType
    {
        (object) ($dynamicTypeFactory = $this->factoryOverloader->overload($dependencyType));
        return $dynamicTypeFactory->create($dependencyType);
    }
}