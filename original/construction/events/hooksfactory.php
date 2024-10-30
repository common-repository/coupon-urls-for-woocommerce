<?php

namespace CouponURLs\Original\Construction\Events;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Abilities\SubscriberFactory;
use CouponURLs\Original\Events\Wordpress\Hook;
use CouponURLs\Original\Events\Wordpress\Hooks;
use CouponURLs\Original\Events\Wordpress\Request;
class HooksFactory
{
    /**
     * @var \CouponURLs\Original\Construction\Events\HookFactory
     */
    protected $hookFactory;
    /**
     * @var \CouponURLs\Original\Construction\Abilities\SubscriberFactory
     */
    protected $subscriberFactory;
    public function __construct(HookFactory $hookFactory, SubscriberFactory $subscriberFactory)
    {
        $this->hookFactory = $hookFactory;
        $this->subscriberFactory = $subscriberFactory;
    }
    public function createFromGroupedSubscriberTypes(Collection $groupedSubscriberTypes) : Hooks
    {
        return new Hooks($groupedSubscriberTypes->map(function (Collection $subscribersGroup, string $hookName) {
            (object) ($hook = $this->hookFactory->createFromRequest(new Request\Action($hookName)));
            $hook->addSubscribers($subscribersGroup->map(function (string $subscriberType) {
                return $this->subscriberFactory->create($subscriberType);
            }));
            return $hook;
        }));
    }
}