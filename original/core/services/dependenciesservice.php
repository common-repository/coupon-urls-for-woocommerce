<?php

namespace CouponURLs\Original\Core\Services;

use CouponURLs\Original\Abilities\GettableCollection;
use CouponURLs\Original\Construction\Dependency\ProductionDependenciesContainerFactory;
use CouponURLs\Original\Core\Abilities\Service;
use CouponURLs\Original\Core\Abilities\ServicesContainer;
use CouponURLs\Original\Dependency\DependenciesContainer;
class DependenciesService implements Service
{
    /**
     * @var \CouponURLs\Original\Construction\Dependency\ProductionDependenciesContainerFactory
     */
    protected $dependenciesContainerFactory;
    /**
     * @var \CouponURLs\Original\Abilities\GettableCollection
     */
    protected $dependencyTypes;
    /**
     * @var \CouponURLs\Original\Dependency\DependenciesContainer|null
     */
    protected $dependenciesContainer;
    public function __construct(ProductionDependenciesContainerFactory $dependenciesContainerFactory, GettableCollection $dependencyTypes)
    {
        $this->dependenciesContainerFactory = $dependenciesContainerFactory;
        $this->dependencyTypes = $dependencyTypes;
    }
    public function id() : string
    {
        return 'dependencies';
    }
    public function container() : ?DependenciesContainer
    {
        return $this->dependenciesContainer;
    }
    public function start(ServicesContainer $servicesContainer) : void
    {
        $this->dependenciesContainer = $this->dependenciesContainerFactory->create($this->dependencyTypes);
    }
    public function stop(ServicesContainer $servicesContainer) : void
    {
        $this->dependenciesContainer = null;
    }
}