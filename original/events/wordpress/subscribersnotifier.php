<?php

namespace CouponURLs\Original\Events\Wordpress;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Events\EventHandlerFactory;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\Abilities\CustomEvent;
use CouponURLs\Original\Events\Wordpress\EventHandler;
use CouponURLs\Original\System\Functions\GlobalFunctionWrapper;
use function CouponURLs\Original\Utilities\Collection\_;
class SubscribersNotifier
{
    /**
     * @var \CouponURLs\Original\System\Functions\GlobalFunctionWrapper
     */
    protected $globalFunctionWrapper;
    /**
     * @var \CouponURLs\Original\Events\Wordpress\EventsHandler
     */
    protected $eventsHandler;
    public function __construct(GlobalFunctionWrapper $globalFunctionWrapper = null, EventsHandler $eventsHandler = null)
    {
        $globalFunctionWrapper = $globalFunctionWrapper ?? new GlobalFunctionWrapper();
        $eventsHandler = $eventsHandler ?? new EventsHandler(new EventHandlerFactory());
        $this->globalFunctionWrapper = $globalFunctionWrapper;
        $this->eventsHandler = $eventsHandler;
    }
    public function addSubscriber(Subscriber $subscriber) : void
    {
        $this->eventsHandler->addSubscriber($subscriber);
    }
    public function notify(CustomEvent $event) : void
    {
        $this->eventsHandler->handle($event);
        do_action(get_class($event), $event);
    }
}