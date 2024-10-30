<?php

namespace CouponURLs\App\Components\Exporters;

use CouponURLs\App\Components\Abilities\ComponentExportable;
use CouponURLs\Original\Collections\Collection;
use function CouponURLs\Original\Utilities\Collection\_;
class ComponentExporterComposite implements ComponentExportable
{
    /**
     * @var \CouponURLs\Original\Collections\Collection
     */
    protected $componentExportables;
    public function __construct(Collection $componentExportables)
    {
        $this->componentExportables = $componentExportables;
    }
    /**
     * @param mixed $componentToExport
     */
    public function export($componentToExport) : Collection
    {
        (array) ($component = []);
        foreach ($this->componentExportables->asArray() as $exportable) {
            $component = array_merge($component, is_array($exportable->export($componentToExport)) ? $exportable->export($componentToExport) : iterator_to_array($exportable->export($componentToExport)));
        }
        return neblabs_collection([$component]);
    }
}