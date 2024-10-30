<?php

namespace CouponURLs\Original\Construction\Dependency;

use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\DependencyInspector;
use CouponURLs\Original\Dependency\Dependent;
class DependencyFactory
{
    /**
     * @var \CouponURLs\Original\Construction\Dependency\DependencyInspectorFactory
     */
    protected $dependencyInspectorFactory;
    /**
     * @var \CouponURLs\Original\Construction\Dependency\DependentFactory
     */
    protected $dependentFactory;
    public function __construct(DependencyInspectorFactory $dependencyInspectorFactory, DependentFactory $dependentFactory)
    {
        $this->dependencyInspectorFactory = $dependencyInspectorFactory;
        $this->dependentFactory = $dependentFactory;
    }
    public function create(string $type) : Dependency
    {
        (object) ($dependencyInspector = $this->dependencyInspectorFactory->create($type));
        switch (true) {
            case $dependencyInspector->hasDependencies():
                return $this->dependentFactory->create($type);
            case $dependencyInspector->isDependency():
                return new $type();
        }
    }
}