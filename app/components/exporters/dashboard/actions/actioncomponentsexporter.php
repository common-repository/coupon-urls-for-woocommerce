<?php

namespace CouponURLs\App\Components\Exporters\Dashboard\Actions;

use CouponURLs\App\Components\Abilities\DashboardExportable;
use CouponURLs\App\Components\Components;
use CouponURLs\App\Components\Exporters\ComponentExporterComposite;
use CouponURLs\App\Components\Exporters\DescriptableExporter;
use CouponURLs\App\Components\Exporters\DescriptablesExporter;
use CouponURLs\App\Components\Exporters\IdentifiableExporter;
use CouponURLs\App\Components\Exporters\InlineOptionsMapExporter;
use CouponURLs\App\Components\Exporters\NameableExporter;
use CouponURLs\Original\Collections\Collection;
use function CouponURLs\Original\Utilities\Collection\_;
class ActionComponentsExporter implements DashboardExportable
{
    /**
     * @var \CouponURLs\App\Components\Components
     */
    protected $actionComponents;
    public function __construct(Components $actionComponents)
    {
        $this->actionComponents = $actionComponents;
    }
    public function key() : string
    {
        return 'actions';
    }
    public function export() : array
    {
        (object) ($exporter = new ComponentExporterComposite(neblabs_collection([new IdentifiableExporter(), new NameableExporter(), new DescriptablesExporter(), new InlineOptionsMapExporter()])));
        return $this->actionComponents->all()->map(\Closure::fromCallable([$exporter, 'export']))->asArray();
    }
}