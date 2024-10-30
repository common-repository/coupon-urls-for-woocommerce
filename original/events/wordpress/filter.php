<?php

namespace CouponURLs\Original\Events\Wordpress;

class Filter extends Hook
{
    public function register() : void
    {
        foreach ($this->subscribers as $subscriber) {
            (object) ($eventHandler = $this->eventHandlerFactory->create($subscriber));
            add_filter($this->name, \Closure::fromCallable([$eventHandler, 'handle']), $subscriber->priority(), $this->numberOfAcceptedArgumentsForSubscriber($subscriber));
        }
    }
    public function unregister() : void
    {
    }
}