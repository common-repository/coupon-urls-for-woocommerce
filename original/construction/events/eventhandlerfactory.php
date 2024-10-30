<?php

namespace CouponURLs\Original\Construction\Events;

use CouponURLs\Original\Construction\Event\Exceptions\ExceptionHandlerFactory;
use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\EventHandler;
class EventHandlerFactory
{
    /**
     * @var \CouponURLs\Original\Construction\Event\Exceptions\ExceptionHandlerFactory
     */
    protected $exceptionHandlerFactory;
    public function __construct(ExceptionHandlerFactory $exceptionHandlerFactory = null)
    {
        $exceptionHandlerFactory = $exceptionHandlerFactory ?? new ExceptionHandlerFactory();
        $this->exceptionHandlerFactory = $exceptionHandlerFactory;
    }
    public function create(Subscriber $subscriber) : Eventhandler
    {
        return new EventHandler($subscriber, $this->exceptionHandlerFactory);
    }
}