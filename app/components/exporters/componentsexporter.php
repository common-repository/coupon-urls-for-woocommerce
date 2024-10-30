<?php

namespace CouponURLs\App\Components\Exporters;

use CouponURLs\App\Components\Abilities\DashboardExportable;
use CouponURLs\App\Components\Components;

abstract class ComponentsExporter implements DashboardExportable
{
    /**
     * @var \CouponURLs\App\Components\Components
     */
    protected $components;
    public function __construct(Components $components)
    {
        $this->components = $components;
    }
    
}