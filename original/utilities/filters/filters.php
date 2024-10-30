<?php

namespace CouponURLs\Original\Utilities\Filters;

function isInstanceOf(string $type) : callable
{
    return function ($item) use ($type) {
        return $item instanceof $type;
    };
}