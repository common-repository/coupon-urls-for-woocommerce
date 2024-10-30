<?php

namespace CouponURLs\App\Components\Abilities;

use CouponURLs\Original\Collections\Collection;

interface ComponentExportable
{
    /**
     * @param mixed $component
     */
    public function export($component) : Collection;
}