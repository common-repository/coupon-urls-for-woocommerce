<?php

namespace CouponURLs\Original\Construction\Events;

use CouponURLs\Original\Construction\Abilities\SubscriberFactory;
use CouponURLs\Original\Dependency\DependenciesContainer;
use CouponURLs\Original\Events\Subscriber;
class FromDependenciesContainerSubscriberFactory implements SubscriberFactory
{
    /**
     * @var \CouponURLs\Original\Dependency\DependenciesContainer
     */
    protected $dependenciesContainer;
    public function __construct(DependenciesContainer $dependenciesContainer)
    {
        $this->dependenciesContainer = $dependenciesContainer;
    }
    public function create(string $subscriberType) : Subscriber
    {
        return $this->dependenciesContainer->get($subscriberType);
    }
}