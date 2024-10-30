<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Abilities\ContainerFactory;
use CouponURLs\Original\Construction\Abilities\CreatableContainers;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\Container;
class DependencyTypeToContainerFactory implements ContainerFactory
{
    /**
     * @var \CouponURLs\Original\Construction\Dependency\DependencyFactory
     */
    protected $dependencyFactory;
    /**
     * @var \CouponURLs\Original\Construction\Dependency\DependencyContainerFactory
     */
    protected $dependencyContainerFactory;
    public function __construct(DependencyFactory $dependencyFactory, DependencyContainerFactory $dependencyContainerFactory)
    {
        $this->dependencyFactory = $dependencyFactory;
        $this->dependencyContainerFactory = $dependencyContainerFactory;
    }
    /** @var string
     * @param string|\CouponURLs\Original\Dependency\Dependency $dependency */
    public function create($dependency) : Container
    {
        return $this->dependencyContainerFactory->create($this->dependencyFactory->create($dependency));
    }
}