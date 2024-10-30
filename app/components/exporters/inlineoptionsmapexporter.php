<?php

namespace CouponURLs\App\Components\Exporters;

use CouponURLs\App\Components\Abilities\ComponentExportable;
use CouponURLs\App\Components\Abilities\Descriptable;
use CouponURLs\App\Components\Abilities\HasInlineOptions;
use CouponURLs\Original\Collections\Collection;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;
class InlineOptionsMapExporter implements ComponentExportable
{
    /** @param mixed $component */
    public function export($component) : Collection
    {
        return neblabs_collection(['options' => $component instanceof HasInlineOptions ? $component->options() : ['__' => null]]);
    }
}