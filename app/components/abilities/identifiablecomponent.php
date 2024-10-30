<?php

namespace CouponURLs\App\Components\Abilities;

interface IdentifiableComponent
{
    /**
     * @return \CouponURLs\App\Components\Abilities\Identifiable|\CouponURLs\App\Components\Abilities\HasDefaultConditions
     */
    public function component(); 
}