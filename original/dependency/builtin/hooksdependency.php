<?php

namespace CouponURLs\Original\Dependency\BuiltIn;

use CouponURLs\Original\Abilities\Cached;
use CouponURLs\Original\Construction\Abilities\SubscriberFactory;
use CouponURLs\Original\Construction\Events\HookFactory;
use CouponURLs\Original\Construction\Events\HooksFactory;
use CouponURLs\Original\Dependency\Abilities\StaticType;
use CouponURLs\Original\Dependency\Dependency;
use CouponURLs\Original\Events\Wordpress\Framework\RegisteredSubscribers;
use CouponURLs\Original\Events\Wordpress\Hooks;
use CouponURLs\Original\Dependency\WillAlwaysMatch;
class HooksDependency implements Cached, StaticType, Dependency
{
    /**
     * @var \CouponURLs\Original\Events\Wordpress\Framework\RegisteredSubscribers
     */
    protected $registeredSubscribers;
    /**
     * @var \CouponURLs\Original\Construction\Abilities\SubscriberFactory
     */
    protected $subscriberFactory;
    /**
     * @var \CouponURLs\Original\Construction\Events\HookFactory
     */
    protected $hookFactory;
    use WillAlwaysMatch;
    public function __construct(RegisteredSubscribers $registeredSubscribers, SubscriberFactory $subscriberFactory, HookFactory $hookFactory)
    {
        $this->registeredSubscribers = $registeredSubscribers;
        $this->subscriberFactory = $subscriberFactory;
        $this->hookFactory = $hookFactory;
    }
    public static function type() : string
    {
        return Hooks::class;
    }
    public function create() : object
    {
        (object) ($hooksFactory = new HooksFactory($this->hookFactory, $this->subscriberFactory));
        return $hooksFactory->createFromGroupedSubscriberTypes($this->registeredSubscribers->get());
    }
}