<?php

namespace CouponURLs\App\Components\Abilities;

use CouponURLs\App\Components\Components;

interface HasDependents
{
    /**
     * @param \CouponURLs\App\Components\Abilities\Identifiable|\CouponURLs\App\Components\Abilities\Typeable $dependent
     */
    public function addDependent($dependent) : void;
    public function dependents() : Components; 
}