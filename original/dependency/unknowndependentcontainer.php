<?php

namespace CouponURLs\Original\Dependency;

class UnknownDependentContainer implements DependentContainer
{
    /**
     * @var \CouponURLs\Original\Dependency\Dependent
     */
    protected $dependent;
    public function __construct(Dependent $dependent)
    {
        $this->dependent = $dependent;
    }
    public function setDependenciesContainer(DependenciesContainer $dependenciesContainer) : void
    {
        $this->dependent->setDependenciesContainer($dependenciesContainer);
    }
    public function matches(string $type) : bool
    {
        return true;
    }
    public function get() : Dependency
    {
        return $this->dependent;
    }
}