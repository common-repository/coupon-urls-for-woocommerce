<?php

namespace CouponURLs\Original\Construction;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\Validators\ItemsAreOnlyInstancesOf;
use CouponURLs\Original\Construction\Abilities\OverloadableFactory;
use Exception;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\validate;
class FactoryOverloader
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $overloadableFactories;
    public function __construct(Collection $overloadableFactories)
    {
        $this->overloadableFactories = $overloadableFactories;
        validate(new ItemsAreOnlyInstancesOf($overloadableFactories, neblabs_collection([OverloadableFactory::class])));
    }
    /**
     * @param mixed $value
     */
    public function overload($value) : OverloadableFactory
    {
        return $this->overloadableFactories->find(function (OverloadableFactory $overloadableFactory) use ($value) {
            return $overloadableFactory->canCreate($value);
        }) ?? $this->throwExceptionWhenNotFound();
    }
    protected function throwExceptionWhenNotFound() : void
    {
        throw new Exception(\esc_html("No overloadableFactory found!"));
    }
}