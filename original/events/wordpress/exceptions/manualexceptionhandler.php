<?php

namespace CouponURLs\Original\Events\Wordpress\Exceptions;

use CouponURLs\Original\Events\Wordpress\Abilities\ExceptionHandler;
use CouponURLs\Original\Events\Wordpress\Abilities\ManuallyHandleExceptions;
use Throwable;
class ManualExceptionHandler implements ExceptionHandler
{
    /**
     * @var \CouponURLs\Original\Events\Wordpress\Abilities\ManuallyHandleExceptions
     */
    protected $handler;
    public function __construct(ManuallyHandleExceptions $handler)
    {
        $this->handler = $handler;
    }
    /**
     * @return mixed
     */
    public function handle(Throwable $exception)
    {
        return $this->handler->onException($exception);
    }
}