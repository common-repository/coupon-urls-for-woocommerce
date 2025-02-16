<?php

namespace CouponURLs\Original\Events\Wordpress;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Events\EventHandlerFactory;
use CouponURLs\Original\Events\Subscriber;
use function CouponURLs\Original\Utilities\Collection\_;
class EventsHandler
{
    /**
     * @var \CouponURLs\Original\Construction\Events\EventHandlerFactory
     */
    protected $eventHandlerFactory;
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $subscribers;
    public function __construct(EventHandlerFactory $eventHandlerFactory)
    {
        $this->eventHandlerFactory = $eventHandlerFactory;
        $this->subscribers = neblabs_collection([]);
    }
    public function addSubscriber(Subscriber $subscriber) : void
    {
        $this->subscribers->push($subscriber);
    }
    public function handle(...$originalArguments) : void
    {
        foreach ($this->subscribers as $subscriber) {
            (object) ($eventHandler = $this->eventHandlerFactory->create($subscriber));
            $eventHandler->handle(...$originalArguments);
        }
    }
}