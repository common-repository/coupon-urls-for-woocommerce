<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Construction\Dependency\DependentFactory;
use CouponURLs\Original\Dependency\Abilities\Context;
use Exception;
use ReflectionClass;
class AutomaticDependencyContainer implements Container
{
    /**
     * @var \CouponURLs\Original\Construction\Dependency\DependentFactory
     */
    protected $dependentFactory;
    /**
     * @var \CouponURLs\Original\Dependency\DependenciesContainer
     */
    protected $dependenciesContainer;
    public function __construct(DependentFactory $dependentFactory)
    {
        $this->dependentFactory = $dependentFactory;
    }
    public function matches(string $type, Context $context) : bool
    {
        return $this->isConcreteClass($type) && $this->dependentFactory->create($type)->canBeCreated($context);
    }
    public function get(string $type) : object
    {
        (object) ($dependent = $this->dependentFactory->create($type));
        $dependent->setDependenciesContainer($this->dependenciesContainer);
        return $dependent->create();
    }
    public function setDependenciesContainer(DependenciesContainer $dependenciesContainer) : void
    {
        $this->dependenciesContainer = $dependenciesContainer;
    }
    protected function isConcreteClass(string $type) : bool
    {
        try {
            (object) ($reflectedType = new ReflectionClass($type));
            return $reflectedType->isInstantiable();
        } catch (Exception $exception) {
            return false;
        }
    }
}