<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Abilities\CreatableContainers;
use CouponURLs\Original\Dependency\AutomaticDependencyContainer;
use function CouponURLs\Original\Utilities\Collection\_;
class AutomaticDependencyContainerFactory implements CreatableContainers
{
    /**
     * @var \CouponURLs\Original\Construction\Dependency\DynamicTypeFactory
     */
    protected $dynamicTypeFactory;
    public function __construct(DynamicTypeFactory $dynamicTypeFactory)
    {
        $this->dynamicTypeFactory = $dynamicTypeFactory;
    }
    public function create() : Collection
    {
        return neblabs_collection([new AutomaticDependencyContainer(new DependentFactory($this->dynamicTypeFactory, new KnownContextFactory()))]);
    }
}