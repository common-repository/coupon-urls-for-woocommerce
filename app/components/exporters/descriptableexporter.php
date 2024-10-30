<?php

namespace CouponURLs\App\Components\Exporters;

use CouponURLs\App\Components\Abilities\ComponentExportable;
use CouponURLs\App\Components\Abilities\Descriptable;
use CouponURLs\Original\Collections\Collection;
use function CouponURLs\Original\Utilities\Collection\_;
class DescriptableExporter implements ComponentExportable
{
    /** @param mixed $component */
    public function export($component) : Collection
    {
        return neblabs_collection(['description' => $component instanceof Descriptable ? (string) $component->description() : '']);
    }
}