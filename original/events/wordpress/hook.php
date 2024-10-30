<?php

namespace CouponURLs\Original\Events\Wordpress;

use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Construction\Events\EventHandlerFactory;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\System\Functions\GlobalFunctionWrapper;
use ReflectionMethod;
use function CouponURLs\Original\Utilities\Collection\a;
abstract class Hook
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var \CouponURLs\Original\System\Functions\GlobalFunctionWrapper
     */
    protected $globalFunctionWraper;
    /**
     * @var \CouponURLs\Original\Construction\Events\EventHandlerFactory
     */
    protected $eventHandlerFactory;
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $subscribers;
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $handlers;
    /**
     * @var \CouponURLs\Original\Events\Wordpress\EventArguments
     */
    protected $eventArguments;
    public abstract function register() : void;
    public abstract function unregister() : void;
    public function __construct(string $name, GlobalFunctionWrapper $globalFunctionWraper = null, EventHandlerFactory $eventHandlerFactory = null)
    {
        $globalFunctionWraper = $globalFunctionWraper ?? new GlobalFunctionWrapper();
        $eventHandlerFactory = $eventHandlerFactory ?? new EventHandlerFactory();
        $this->name = $name;
        $this->globalFunctionWraper = $globalFunctionWraper;
        $this->eventHandlerFactory = $eventHandlerFactory;
        $this->subscribers = new Collection([]);
        $this->handlers = new Collection([]);
    }
    public function add(Subscriber $subscriber) : void
    {
        $this->subscribers->push($subscriber);
    }
    public function addHandler(callable $handler, int $priority) : void
    {
        $this->handlers->push(['handler' => $handler, 'priority' => $priority]);
    }
    public function removeHandler(callable $handlerToRemove) : void
    {
        $this->handlers->filterAndRemove(function (array $handlerAndPriority) use ($handlerToRemove) {
            return $handlerAndPriority['handler'] === $handlerToRemove;
        });
    }
    public function addSubscribers(Collection $subscribers) : void
    {
        $subscribers->forEvery(function (Subscriber $subscriber) {
            return $this->add($subscriber);
        });
    }
    /** 
     * Ideally, this would be a method of Subscriber, but
     * since it's an interface, we'll just implement it here.
     * 
     */
    protected function numberOfAcceptedArgumentsForSubscriber(Subscriber $subscriber) : int
    {
        (object) ($reflectionMethod = new ReflectionMethod($subscriber, 'createEventArguments'));
        return $reflectionMethod->getNumberOfParameters();
    }
}