<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Construction\Abilities\ContainerFactory;
use CouponURLs\Original\Construction\Abilities\OverloadableFactory;
use CouponURLs\Original\Construction\Dependency\DependencyContainerFactory;
use CouponURLs\Original\Dependency\Container;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\Dependent;
use CouponURLs\Original\Dependency\DependentDependencyContainer;
class DependentDependencyContainerFactory implements ContainerFactory, OverloadableFactory
{
    /**
     * @var \CouponURLs\Original\Construction\Dependency\DependencyInspectorFactory
     */
    protected $dependencyInspectorFactory;
    /**
     * @var \CouponURLs\Original\Construction\Dependency\DependencyContainerFactory
     */
    protected $dependencyContainerFactory;
    public function __construct(DependencyInspectorFactory $dependencyInspectorFactory, DependencyContainerFactory $dependencyContainerFactory)
    {
        $this->dependencyInspectorFactory = $dependencyInspectorFactory;
        $this->dependencyContainerFactory = $dependencyContainerFactory;
    }
    /** @var Dependency
     * @param mixed $value */
    public function canCreate($value) : bool
    {
        (object) ($dependencyInspector = $this->dependencyInspectorFactory->create(get_class($value)));
        return $dependencyInspector->isDependent();
    }
    /** @var Dependent
     * @param string|\CouponURLs\Original\Dependency\Dependency $dependency */
    public function create($dependency) : Container
    {
        return new DependentDependencyContainer($dependency, $this->dependencyContainerFactory);
    }
}