<?php

namespace CouponURLs\Original\Abilities;

interface Comparable
{
    public function isTheSameAs($value) : bool;
}