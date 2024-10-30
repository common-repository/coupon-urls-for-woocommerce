<?php

namespace CouponURLs\App\Components\Exporters;

use CouponURLs\App\Components\Abilities\ComponentExportable;
use CouponURLs\App\Components\Abilities\Descriptable;
use CouponURLs\App\Components\Abilities\Descriptables;
use CouponURLs\Original\Collections\Collection;
use function CouponURLs\Original\Utilities\Collection\_;
class DescriptablesExporter implements ComponentExportable
{
    /** @param mixed $component */
    public function export($component) : Collection
    {
        return neblabs_collection(['descriptions' => $component instanceof Descriptables ? $component->descriptions() : []]);
    }
}