<?php

namespace CouponURLs\Original\Construction\Abilities;

interface OverloadableFactory
{
    /**
     * @param mixed $value
     */
    public function canCreate($value) : bool;
}