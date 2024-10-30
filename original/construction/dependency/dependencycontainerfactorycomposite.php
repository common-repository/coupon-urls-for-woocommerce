<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Construction\Abilities\ContainerFactory;
use CouponURLs\Original\Construction\Abilities\DependencyContainerFactory;
use CouponURLs\Original\Construction\FactoryOverloader;
use CouponURLs\Original\Dependency\Container;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\DependencyContainer;
class DependencyContainerFactoryComposite implements ContainerFactory
{
    /**
     * @var \CouponURLs\Original\Construction\FactoryOverloader
     */
    protected $factoryOverloader;
    public function __construct(FactoryOverloader $factoryOverloader)
    {
        $this->factoryOverloader = $factoryOverloader;
    }
    /**
     * @param string|\CouponURLs\Original\Dependency\Dependency $dependency
     */
    public function create($dependency) : Container
    {
        /** @var DependencyContainerFactory */
        (object) ($dependencyContainerFactory = $this->factoryOverloader->overload($dependency));
        return $dependencyContainerFactory->create($dependency);
    }
}