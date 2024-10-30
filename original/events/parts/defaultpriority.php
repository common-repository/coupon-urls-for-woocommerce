<?php

namespace CouponURLs\Original\Events\Parts;

trait DefaultPriority
{
    public function priority() : int
    {
        return 10;
    }
}