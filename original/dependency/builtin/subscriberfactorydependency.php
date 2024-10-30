<?php

namespace CouponURLs\Original\Dependency\BuiltIn;

use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Construction\Abilities\SubscriberFactory;
use CouponURLs\Original\Construction\Events\FromDependenciesContainerSubscriberFactory;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\DependenciesContainer;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Dependency\Abilities\Context;
class SubscriberFactoryDependency implements Cached, StaticType, Dependency
{
    /**
     * @var \CouponURLs\Original\Dependency\DependenciesContainer
     */
    protected $dependenciesContainer;
    public function __construct(DependenciesContainer $dependenciesContainer)
    {
        $this->dependenciesContainer = $dependenciesContainer;
    }
    public static function type() : string
    {
        return SubscriberFactory::class;
    }
    public function canBeCreated(Context $context) : bool
    {
        return true;
    }
    public function create() : object
    {
        return new FromDependenciesContainerSubscriberFactory($this->dependenciesContainer);
    }
}