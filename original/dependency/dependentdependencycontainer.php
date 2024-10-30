<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Cache\Cache;
use CouponURLs\Original\Cache\MemoryCache;
use CouponURLs\Original\Construction\Abilities\ContainerFactory;
use CouponURLs\Original\Dependency\Abilities\Context;
class DependentDependencyContainer implements Container
{
    /**
     * @var \CouponURLs\Original\Dependency\Dependent
     */
    protected $dependent;
    /**
     * @var \CouponURLs\Original\Construction\Abilities\ContainerFactory
     */
    protected $dependencyContainerFactory;
    /**
     * @var \CouponURLs\Original\Cache\Cache
     */
    protected $storage;
    public function __construct(Dependent $dependent, ContainerFactory $dependencyContainerFactory, Cache $storage = null)
    {
        $storage = $storage ?? new MemoryCache();
        $this->dependent = $dependent;
        $this->dependencyContainerFactory = $dependencyContainerFactory;
        $this->storage = $storage;
    }
    public function setDependenciesContainer(DependenciesContainer $dependenciesContainer) : void
    {
        $this->dependent->setDependenciesContainer($dependenciesContainer);
    }
    public function matches(string $type, Context $context) : bool
    {
        return is_a($type, $this->dependent->type(), true) && $this->dependencyContainer()->matches($type, $context);
    }
    public function get(string $type) : object
    {
        return $this->dependencyContainer()->get($type);
    }
    protected function dependencyContainer() : DependencyContainer
    {
        return $this->storage->getIfExists('dependencyContainer')->otherwise(function () {
            return $this->dependencyContainerFactory->create($this->dependent->create());
        });
    }
}