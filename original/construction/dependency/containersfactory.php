<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Abilities\CreatableContainers;
use CouponURLs\Original\Dependency\DependencyContainer;
use CouponURLs\Original\Dependency\Dependent;
use CouponURLs\Original\Dependency\DependentDependencyContainer;
use function CouponURLs\Original\Utilities\Collection\_;
class ContainersFactory implements CreatableContainers
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $factories;
    public function __construct(Collection $factories)
    {
        $this->factories = $factories;
    }
    public function create() : Collection
    {
        return $this->factories->map(function ($factory) {
            return $factory->create();
        })->flatten();
    }
}