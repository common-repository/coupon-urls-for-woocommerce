<?php

namespace CouponURLs\Original\Events\Parts;

use CouponURLs\Original\Events\Wordpress\EventArguments;
use function CouponURLs\Original\Utilities\Collection\_;
trait EmptyCustomArguments
{
    public function createEventArguments() : EventArguments
    {
        return new EventArguments(neblabs_collection([]));
    }
}