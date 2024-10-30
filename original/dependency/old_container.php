<?php

namespace CouponURLs\Original\Dependency;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\Validators\ItemsAreOnlyInstancesOf;
use Exception;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\validate;
class Old_Container
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $dependencies;
    public function __construct(Collection $dependencies)
    {
        $this->dependencies = $dependencies;
        validate(new ItemsAreOnlyInstancesOf($dependencies, neblabs_collection([Dependency::class])));
    }
    public function inject(string $fullyQualifiedTypeName) : object
    {
        return $this->dependenciesForType($fullyQualifiedTypeName)->first();
    }
    protected function dependenciesForType(string $fullyQualifiedTypeName): Collection
    {
        if ($this->dependencies->get($fullyQualifiedTypeName) !== null) {
            throw new Exception(\esc_html("No registered dependency for type: {$fullyQualifiedTypeName}"));
        }
        return $this->dependencies->get($fullyQualifiedTypeName);
    }
}