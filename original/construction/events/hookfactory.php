<?php

namespace CouponURLs\Original\Construction\Events;

use CouponURLs\Original\Events\Wordpress\Action;
use CouponURLs\Original\Events\Wordpress\Filter;
use CouponURLs\Original\Events\Wordpress\Hook;
use CouponURLs\Original\Events\Wordpress\Request;
class HookFactory
{
    public function createFromRequest(Request\Hook $hookRequest) : Hook
    {
        (string) ($name = $hookRequest->name());
        switch ($hookRequest->type()) {
            case Action::class:
                return new Action($name);
            case Filter::class:
                return new Filter($name);
        }
    }
}