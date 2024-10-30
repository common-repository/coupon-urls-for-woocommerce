<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Construction\FactoryOverloader;
use function CouponURLs\Original\Utilities\Collection\_;
class ProductionDynamicTypeFactory
{
    public function create() : DynamicTypeFactory
    {
        return new DynamicTypeFactory(new FactoryOverloader(neblabs_collection([new DependentDynamicTypeFactory(), new DependencyDynamicTypeFactory()])));
    }
}