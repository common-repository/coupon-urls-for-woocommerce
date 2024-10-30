<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Dependency\Abilities\Context;
use CouponURLs\Original\Dependency\Abilities\StaticType;
abstract class DependencyContainer implements Container
{
    /**
     * @var (\CouponURLs\Original\Dependency\Abilities\StaticType & \CouponURLs\Original\Dependency\Dependency)
     */
    protected $dependency;
    # from the Container interface, its here for clarity.
    public abstract function get(string $type) : object;
    public function matches(string $type, Context $context) : bool
    {
        return $this->isValidType($type) && $this->dependency->canBeCreated($context);
    }
    protected function isValidType(string $type) : bool
    {
        return is_a($type, $this->dependency::type(), true);
    }
    public function setDependenciesContainer(DependenciesContainer $dependenciesContainer) : void
    {
        // this method isnt being used and in an ideal world it shouldnt be here,
        // but oh, well. The overall dependency injection system turned out to be
        // much more complex than I expected, so this is the best I could design atm.
        // Will probably refactor it later.
    }
}