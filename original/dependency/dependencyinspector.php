<?php

namespace CouponURLs\Original\Dependency;

use ReflectionClass;
class DependencyInspector
{
    /**
     * @var string
     */
    protected $dependency;
    public function __construct(string $dependency)
    {
        $this->dependency = $dependency;
    }
    public function isDependency() : bool
    {
        return is_a($this->dependency, Dependency::class, true);
    }
    public function hasDependencies() : bool
    {
        (bool) ($itsNotAClass = !class_exists($this->dependency));
        if ($itsNotAClass) {
            return false;
        }
        (object) ($reflector = new ReflectionClass($this->dependency));
        (object) ($constructor = $reflector->getConstructor());
        (bool) ($hasNoConstructor = !$constructor);
        if ($hasNoConstructor) {
            return false;
        }
        return (bool) $constructor->getParameters();
    }
    public function isDependent() : bool
    {
        return is_a($this->dependency, Dependent::class, true);
    }
}