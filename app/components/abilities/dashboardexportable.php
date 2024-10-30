<?php

namespace CouponURLs\App\Components\Abilities;

use CouponURLs\Original\Characters\StringManager;

interface DashboardExportable extends Exportable
{
    public function key() : string; 
    /**
     * @return mixed[]|\CouponURLs\Original\Characters\StringManager|string|bool|int|float
     */
    public function export();
}