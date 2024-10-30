<?php

namespace CouponURLs\Original\Core\Services;

use CouponURLs\Original\Construction\Events\EventHandlerFactory;
use CouponURLs\Original\Core\Abilities\Service;
use CouponURLs\Original\Core\Abilities\ServicesContainer;
use CouponURLs\Original\Core\Application;
use CouponURLs\Original\Subscribers\ServicesRestarter;
use Closure;
/**
 * Restarts the services when 'init' gets called 
 * Very important if the 'init' action hook is called
 * more than once in the same request.
 *
 * By restarting the services, we make sure that the action hook subscribers
 * are only registered once.
 */
class MonitorService implements Service
{
    /**
     * @var \Closure|null
     */
    protected $handler;
    public function id() : string
    {
        return 'monitor';
    }
    /** @param Application $servicesContainer */
    public function start(ServicesContainer $servicesContainer) : void
    {
        (object) ($servicesRestarterSubscriber = new ServicesRestarter($servicesContainer));
        (object) ($eventHandlerFactory = new EventHandlerFactory());
        (object) ($eventHandler = $eventHandlerFactory->create($servicesRestarterSubscriber));
        $this->handler = \Closure::fromCallable([$eventHandler, 'handle']);
        add_action('init', $this->handler);
    }
    public function stop(ServicesContainer $servicesContainer) : void
    {
        remove_action('init', $this->handler);
        $this->handler = null;
    }
}