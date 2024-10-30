<?php

namespace CouponURLs\Original\Events\Wordpress;

use CouponURLs\Original\Events\Wordpress\EventHandler;
use function CouponURLs\Original\Utilities\Collection\_;
class Action extends Hook
{
    public function register() : void
    {
        foreach ($this->subscribers as $subscriber) {
            (object) ($eventHandler = $this->eventHandlerFactory->create($subscriber));
            (object) ($handle = \Closure::fromCallable([$eventHandler, 'handle']));
            $this->addHandler($handle, $subscriber->priority());
            add_action($this->name, $handle, $subscriber->priority(), $this->numberOfAcceptedArgumentsForSubscriber($subscriber));
        }
    }
    public function unregister() : void
    {
        $this->handlers->forEvery(function (array $handlerAndPriority) {
            return remove_action($this->name, $handlerAndPriority['handler'], $handlerAndPriority['priority']);
        });
        $this->handlers = neblabs_collection([]);
    }
}