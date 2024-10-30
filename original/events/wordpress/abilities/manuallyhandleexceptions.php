<?php

namespace CouponURLs\Original\Events\Wordpress\Abilities;

use Throwable;
interface ManuallyHandleExceptions
{
    /**
     * @return mixed
     */
    public function onException(Throwable $exception);
}