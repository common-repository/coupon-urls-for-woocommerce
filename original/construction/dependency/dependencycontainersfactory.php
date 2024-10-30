<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Abilities\ContainerFactory;
use CouponURLs\Original\Construction\Abilities\CreatableContainers;
class DependencyContainersFactory implements CreatableContainers
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $dependencyTypes;
    /**
     * @var \CouponURLs\Original\Construction\Abilities\ContainerFactory
     */
    protected $dependencyContainerFactory;
    public function __construct(Collection $dependencyTypes, ContainerFactory $dependencyContainerFactory)
    {
        $this->dependencyTypes = $dependencyTypes;
        $this->dependencyContainerFactory = $dependencyContainerFactory;
    }
    public function create() : Collection
    {
        return $this->dependencyTypes->map(\Closure::fromCallable([$this->dependencyContainerFactory, 'create']));
    }
}