<?php

namespace CouponURLs\Original\Events\Wordpress\Request;

use CouponURLs\Original\Events\Wordpress;
class Action extends Hook
{
    public function type() : string
    {
        return Wordpress\Action::class;
    }
}