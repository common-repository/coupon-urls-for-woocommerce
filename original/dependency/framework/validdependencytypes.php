<?php

namespace CouponURLs\Original\Dependency\Framework;

use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Abilities\GettableCollection;
use CouponURLs\Original\Abilities\UnCached;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\Validators\ItemsHaveObjectTypeOf;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\Exceptions\InvalidDependencyException;
use CouponURLs\Original\Validation\Validators;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\validate;
class ValidDependencyTypes implements GettableCollection
{
    /**
     * @var \CouponURLs\Original\Abilities\GettableCollection
     */
    protected $dependencyTypesGetter;
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $dependencyTypes;
    public function __construct(GettableCollection $dependencyTypesGetter)
    {
        $this->dependencyTypesGetter = $dependencyTypesGetter;
        $this->dependencyTypes = $this->dependencyTypesGetter->get();
        validate(new Validators([
            (new ItemsHaveObjectTypeOf($this->dependencyTypes, neblabs_collection([Dependency::class])))->withException(new InvalidDependencyException(\esc_html("One or more of your dependencies do not implement " . Dependency::class))),
            (new ItemsHaveObjectTypeOf($this->dependencyTypes, neblabs_collection([StaticType::class])))->withException(new InvalidDependencyException(\esc_html("One or more of your dependencies do not implement " . StaticType::class . ". Direct Dependency classes may only implement StaticType."))),
            //
            (new ItemsHaveObjectTypeOf($this->dependencyTypes, neblabs_collection([UnCached::class, Cached::class])))->withException(new InvalidDependencyException(\esc_html("Each Dependency must implement either " . UnCached::class . " or " . Cached::class))),
        ]));
    }
    public function get() : Collection
    {
        return $this->dependencyTypes;
    }
}