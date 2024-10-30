<?php

namespace CouponURLs\Original\Construction\Event\Exceptions;

use CouponURLs\Original\Events\Subscriber;
use CouponURLs\Original\Events\Wordpress\Abilities\AutomaticallyHandleExceptions;
use CouponURLs\Original\Events\Wordpress\Abilities\ExceptionHandler;
use CouponURLs\Original\Events\Wordpress\Abilities\ManuallyHandleExceptions;
use CouponURLs\Original\Events\Wordpress\Exceptions\ManualExceptionHandler;
use CouponURLs\Original\Events\Wordpress\Exceptions\SilentExceptionHandler;
use CouponURLs\Original\Events\Wordpress\Exceptions\UnhandledExceptionHandler;
class ExceptionHandlerFactory
{
    /**
     * @param \CouponURLs\Original\Events\Subscriber|\CouponURLs\Original\Events\Wordpress\Abilities\ManuallyHandleExceptions $subscriber
     */
    public function create($subscriber) : ExceptionHandler
    {
        switch (true) {
            case $subscriber instanceof AutomaticallyHandleExceptions:
                return new SilentExceptionHandler();
            case $subscriber instanceof ManuallyHandleExceptions:
                return new ManualExceptionHandler($subscriber);
            default:
                return new UnhandledExceptionHandler();
        }
    }
}