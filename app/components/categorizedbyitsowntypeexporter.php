<?php

namespace CouponURLs\App\Components;

use CouponURLs\App\Components\Abilities\ComponentExportable;
use CouponURLs\App\Components\Abilities\Identifiable;
use CouponURLs\Original\Collections\Collection;
use function CouponURLs\Original\Utilities\Collection\_;
class CategorizedByItsOwnTypeExporter implements ComponentExportable
{
    /**
     * @var \CouponURLs\App\Components\Abilities\ComponentExportable
     */
    protected $exporter;
    public function __construct(ComponentExportable $exporter)
    {
        $this->exporter = $exporter;
    }
    /** @param mixed $component */
    public function export($component) : Collection
    {
        return neblabs_collection([$component->identifier() => $this->exporter->export($component)]);
    }
}